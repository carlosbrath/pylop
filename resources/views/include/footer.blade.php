 <!-- <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
 <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
 <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
 <!-- <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script> -->
 <script src="{{ asset('assets/js/scripts.js') }}"></script>

 <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}" crossorigin="anonymous"></script>
 {{-- <script src="{{ asset('assets/demo/chart-area-demo.js') }}" crossorigin="anonymous"></script> --}}
 <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script> -->
 {{-- <script src="{{ asset('assets/vendor/datatables/simple-datatables.min.js') }}"></script>
 <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script> --}}

 <!-- DataTables core + Bootstrap 4 integration -->
 <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

 <!-- DataTables buttons (export, print, etc.) -->
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="{{ asset('assets/js/litepicker.js') }}"></script>
 <script src="{{ asset('assets/js/custom.js') }}"></script>
 <sb-customizer project="sb-admin-pro"></sb-customizer>
 <script>
     const routeMap = {
         'get.tehsils': "{{ route('get.tehsils', ':id') }}",
         'get.branches': "{{ route('get.branches', ':id') }}",
         'get.subcategories': "{{ route('get.subcategories', ':id') }}"
     };
     $(document).ready(function() {
         $('input[name="cnic"]').mask('00000-0000000-0');
         $('input[name="phone"]').mask('00000000000');
         $('#amount').mask('0,000,000', {
             reverse: true
         });
         $('.select2').select2({
             allowClear: true,
             width: '100%'
         });
     });
     window.addEventListener('DOMContentLoaded', event => {
         const litepickerRangePluginele = document.getElementById('litepickerRangePlugin');
         if (litepickerRangePluginele) {
             new Litepicker({
                 element: litepickerRangePluginele,
                 startDate: '{{ $date_from ?? '' }}',
                 endDate: '{{ $date_to ?? '' }}',
                 singleMode: false,
                 numberOfMonths: 2,
                 numberOfColumns: 2,
                 format: 'MMM DD, YYYY',
                 plugins: ['ranges'],
                 setup: (picker) => {
                     picker.on('selected', (date1, date2) => {
                         console.log(date1)
                         console.log(date2)
                         let dateFrom = date1.format('YYYY-MM-DD');
                         let dateTo = date2.format('YYYY-MM-DD');
                         let url = new URL(window.location.href);
                         url.searchParams.set('date_from', dateFrom);
                         url.searchParams.set('date_to', dateTo);
                         window.location.href = url.toString();
                     });
                 },
             });
         }
     })
     document.addEventListener('click', function(e) {
         const btn = e.target.closest('.delete-btn');
         if (!btn) return;

         e.preventDefault();
         const url = btn.getAttribute('data-href');
         const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

         Swal.fire({
             title: 'Are you sure?',
             text: "This record will be permanently deleted!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#d33',
             cancelButtonColor: '#6c757d',
             confirmButtonText: 'Yes, delete it!',
             cancelButtonText: 'Cancel'
         }).then((result) => {
             if (result.isConfirmed) {
                 fetch(url, {
                         method: 'DELETE',
                         headers: {
                             'X-CSRF-TOKEN': csrf,
                             'Accept': 'application/json'
                         }
                     })
                     .then(res => res.json())
                     .then(data => {
                         if (data.status === 'success') {
                             Swal.fire('Deleted!', data.message, 'success').then(() => {
                                 // Redirect to applicants.index
                                 window.location.href = data.redirect;
                             });
                         } else {
                             Swal.fire('Error!', data.message || 'Failed to delete.', 'error');
                         }
                     })
                     .catch(() => {
                         Swal.fire('Error!', 'Something went wrong.', 'error');
                     });
             }
         });
     });

     function validateForm(event, form, id) {
         event.preventDefault();
         var inputs = form.querySelectorAll('input');
         var selects = form.querySelectorAll('select');
         var isValid = true;
         selects.forEach(function(select) {
            
            if ((!select.value || select.value === '') && select.classList.contains('required')) {
                 select.classList.add('error');
                 isValid = false;
                 field_name = formatFieldName(select.name)
                 removeErrorComponent(select);
                 createErrorComponent(select, field_name + ' is required.');
             } else {
                 removeErrorComponent(select);
                 select.classList.remove('error');
             }
         })
         inputs.forEach(function(input) {
            
           
             if ((input.value === '' || !input.value) && input.classList.contains('required')) {
                 console.log('Type: '+input.type+' Name:' +input.name+': '+((!input.value || input.value === '')&& input.classList.contains('required')))
                 input.classList.add('error');

                 isValid = false;
                 field_name = formatFieldName(input.name)
                 removeErrorComponent(input);
                 createErrorComponent(input, '' + field_name + ' required.', '');

             } else {
                 console.log(input.value)
                 input.classList.remove('error');
                 removeErrorComponent(input);
                 if (input.name == 'cnic') {
                     if (!cnicValidation(input, input.name, input.value)) {
                         isValid = false
                     }
                 }
                 if (input.name == 'phone') {
                     if (!phoneValidation(input, input.name, input.value)) {
                         isValid = false
                     }
                 }
                 if (input.name === 'amount') {
                     if (!amountValidation(input)) {
                         isValid = false;
                     }
                 }
                 if (input.name === 'amount') {
                     if (!amountValidation(input)) {
                         isValid = false;
                     }
                 }
             }
             if (input.name === 'dob') {
                 if (!dateofBirth(input)) {
                     isValid = false;
                 }
             }

             // ✅ CNIC Issue Date validation (not older than 10 years)
             if (input.name === 'cnic_issue_date') {
                 if (!cnicIssueDate(input)) {
                     isValid = false;
                 }
             }
             if (input.name === 'cnic_front' || input.name === 'cnic_back') {
                 if (!fileValidation(input)) {
                     isValid = false;
                 }
             }
         });
         if (!isValid) {
             const firstInvalid = form.querySelector('.error');
             if (firstInvalid) {
                 firstInvalid.scrollIntoView({
                     behavior: 'smooth',
                     block: 'center'
                 });
                 firstInvalid.focus();
             }
         }
         if (isValid) {
             event.target.submit();
         }
     }

     function amountValidation(input) {
         const tierSelect = document.querySelector('select[name="tier"]');
         const tier = tierSelect ? tierSelect.value : null;
         const amount = parseInt(input.value.replace(/,/g, ''), 10);

         const tierLimits = {
             1: {
                 min: 0,
                 max: 500000
             },
             2: {
                 min: 500001,
                 max: 1000000
             },
             3: {
                 min: 1000001,
                 max: 2000000
             }
         };
         const displayRanges = {
             1: {
                 min: 0,
                 max: 500000
             },
             2: {
                 min: 500000,
                 max: 1000000
             },
             3: {
                 min: 1000000,
                 max: 2000000
             }
         };

         const limits = tierLimits[tier];
         const display = displayRanges[tier];

         if (!limits || isNaN(amount) || amount < limits.min || amount > limits.max) {
             const message =
                 `For Tier ${tier}, amount must be between ${display.min.toLocaleString()} and ${display.max.toLocaleString()}`;
             createErrorComponent(input, message);
             showToast(message, 'left', 'bottom');
             input.classList.add('error');
             return false;
         }

         input.classList.remove('error');
         removeErrorComponent(input);
         return true;
     }

     function cnicValidation(input, elemName, elemeValue) {
         // Allow both dashed and non-dashed formats
         const cnicRegex = /^(\d{5}-\d{7}-\d{1}|\d{13})$/;

         if (!elemeValue.match(cnicRegex)) {
             input.classList.add('error');
             showToast("Please enter a valid " + elemName, "left", "bottom");

             // Optional: Show inline error
             removeErrorComponent(input);
             createErrorComponent(input, "Please enter a valid " + elemName);

             return false;
         } else {
             input.classList.remove('error');
             removeErrorComponent(input);
             return true;
         }
     }

     function phoneValidation(input, elemName, elemeValue) {
         // Allow both dashed and non-dashed formats
         const phoneRegex = /^(03\d{9})$/;

         if (!elemeValue.match(phoneRegex)) {
             input.classList.add('error');
             elemName = getFormatedname(input)

             // Optional: Show inline error
             removeErrorComponent(input);
             createErrorComponent(input, "Please enter a valid " + elemName + " 03XXXXXXXXX");

             return false;
         } else {
             input.classList.remove('error');
             removeErrorComponent(input);
             return true;
         }
     }

     function dateofBirth(input) {
         const dob = new Date(input.value);
         const today = new Date();
         const age = today.getFullYear() - dob.getFullYear();
         const monthDiff = today.getMonth() - dob.getMonth();
         const dayDiff = today.getDate() - dob.getDate();

         let finalAge = age;
         if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
             finalAge--; // Adjust if birthday not reached yet
         }
         if (finalAge < 18 || finalAge > 40) {
             input.classList.add('error');
             removeErrorComponent(input);
             createErrorComponent(input, 'Not eligible. Age must be 18–40 years..');
             return false
         } else {
             input.classList.remove('error');
             removeErrorComponent(input);
             return true
         }
     }

     function cnicIssueDate(input) {
         const issueDate = new Date(input.value);
         const today = new Date();

         const diffYears = today.getFullYear() - issueDate.getFullYear();
         const monthDiff = today.getMonth() - issueDate.getMonth();
         const dayDiff = today.getDate() - issueDate.getDate();

         let finalYears = diffYears;
         if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
             finalYears--; // Adjust if issue date anniversary not reached
         }

         if (finalYears > 10) {
             isValid = false;
             input.classList.add('error');
             removeErrorComponent(input);
             createErrorComponent(input, 'CNIC expired. Must be issued within last 10 years.');
             return false;
         } else {
             input.classList.remove('error');
             removeErrorComponent(input);
             return true
         }
     }

     function fileValidation(input) {
         if (!input.files || input.files.length === 0) {
             createErrorComponent(input, 'CNIC file is required.');
             input.classList.add('error');
             return false;
         }

         const file = input.files[0];
         const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
         const maxSize = 1 * 1024 * 1024; // 1 MB

         // Check file type
         if (!allowedTypes.includes(file.type)) {
             createErrorComponent(input, 'Only JPG or PNG files are allowed.');
             input.classList.add('error');
             return false;
         }

         // Check file size
         if (file.size > maxSize) {
             createErrorComponent(input, 'File size must not exceed 1 MB.');
             input.classList.remove('error');
             return false;
         }

         // ✅ Valid file
         removeErrorComponent(input);
         input.classList.remove('error');
         return true;
     }



     function confirmDelete(url, id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "Do you really want to delete this item?",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#d33',
             cancelButtonColor: '#3085d6',
             confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
             if (result.isConfirmed) {
                 deleteItem(`${url}`);
             }
         });
     }

     function previewImage(event) {
         var reader = new FileReader();
         console.log(reader.result)
         reader.onload = function() {

             var output = document.getElementById('profile-image');
             output.src = reader.result;
         };
         reader.readAsDataURL(event.target.files[0]);
     }

     function deleteItem(url) {
         fetch(`${url}`, {
                 method: 'DELETE',
                 headers: {
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                     'Accept': 'application/json'
                 }
             })
             .then(response => response.json())
             .then(data => {
                 Swal.fire(
                     'Deleted!',
                     'Your item has been deleted.',
                     'success'
                 ).then(() => {
                     location.reload();
                 });
             })
             .catch(error => {
                 Swal.fire(
                     'Error!',
                     'There was a problem deleting the item.',
                     'error'
                 );
             });
     }

     function attachOnChangeToInputsSelects() {
         // Get all the input elements on the page
         var inputs = document.getElementsByTagName('input');
         var selects = document.getElementsByTagName('select');

         // Iterate over each input field
         for (var i = 0; i < inputs.length; i++) {
             // Attach the onchange event handler to the current input field
             // inputs[i].addEventListener('change', handleInputChange);
             // inputs[i].addEventListener('input', handleInputInput);
         }
         for (var i = 0; i < selects.length; i++) {
             // Attach the onchange event handler to the current input field
             selects[i].addEventListener('change', handleSelectChange);
             // selects[i].addEventListener('input', handleSelectInput);
         }
     }
     attachOnChangeToInputsSelects();

     function handleSelectChange(event) {
         var select = event.target;
         var value = select.value;
         var name = select.getAttribute('name');

         // Remove any non-numeric characters

         if (name === 'role_id') {
             var districtDiv = document.querySelector('.district-div');
             var entrypointDiv = document.querySelector('.entrypoints-div');

             if (value == 5) {
                 districtDiv.style.display = "block";
                 entrypointDiv.style.display = "block";
             } else if (value == 4) {
                 districtDiv.style.display = "block";
                 entrypointDiv.style.display = "none";
             } else if (value == 2 || value == 3) {
                 districtDiv.style.display = "none";
                 entrypointDiv.style.display = "none";
             } else {
                 districtDiv.style.display = "none";
                 entrypointDiv.style.display = "none";
             }
         }

     }

     function fetchonChangeSelect(select, updateSelect, routeName) {
         let url = routeMap[routeName].replace(':id', select.value);
         fetch(url)
             .then(response => response.json())
             .then(data => {
                 if (updateSelect.name == 'tehsil_id') {
                     updateSelect.innerHTML = '<option value="">Select Tehsil</option>';
                     data.forEach(tehsil => {
                         updateSelect.innerHTML +=
                             `<option value="${tehsil.id}">${tehsil.name} / ${tehsil.name_ur}</option>`;
                     });
                 }
                 if (updateSelect.name == 'business_sub_category_id') {
                     updateSelect.innerHTML = '<option value="">Select Subcategory</option>';
                     data.forEach(sub => {
                         updateSelect.innerHTML +=
                             `<option value="${sub.id}">${sub.name}</option>`;
                     });
                     updateSelect.innerHTML += `<option value="100">Others</option>`
                 }
                 if (updateSelect.name == 'applicant_choosed_branch') {
                     updateSelect.innerHTML = '<option value="">Select Branches</option>';
                     data.forEach(sub => {
                         updateSelect.innerHTML +=
                             `<option value="${sub.id}">${sub.branch_code} ${sub.branch_name}</option>`;
                     });
                 }
             });
     }
 </script>
 {{-- <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
     integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
     data-cf-beacon='{"rayId":"8ae5ec1cafafc914","version":"2024.7.0","serverTiming":{"name":{"cfL4":true}},"token":"6e2c2575ac8f44ed824cef7899ba8463","b":1}'
     crossorigin="anonymous"></script> --}}
