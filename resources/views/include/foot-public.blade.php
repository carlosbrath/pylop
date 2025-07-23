 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

 <script>
     const routeMap = {
         'get.tehsils': "{{ route('get.tehsils', ':id') }}",
         'get.branches': "{{ route('get.branches', ':id') }}",
         'get.subcategories': "{{ route('get.subcategories', ':id') }}"
     };
     $(document).ready(function() {
         $('input[name="cnic"]').mask('00000-0000000-0');
         $('input[name="phone"]').mask('00000000000');
         $('.select2').select2({
             allowClear: true,
             width: '100%'
         });
     });

     function validateForm(event, form, id) {
         console.log('validate')
         event.preventDefault();
         var inputs = form.querySelectorAll('input');
         var selects = form.querySelectorAll('select');
         var isValid = true;
         selects.forEach(function(select) {
             console.log(select.value)
             if ((!select.value || select.value === '') && select.classList.contains('required')) {
                 select.classList.add('error');
                 isValid = false;
                 field_name = getFormatedname(select)
                 removeErrorMessage(select);
                 createErrorMessage(select, field_name + ' is required.');
             } else {
                 removeErrorMessage(select);
                 select.classList.remove('error');
             }
         })
         inputs.forEach(function(input) {
             if (input.value.trim() === '' && input.classList.contains('required')) {
                 input.classList.add('error');
                 isValid = false;
                 field_name = getFormatedname(input)
                 removeErrorMessage(input);
                 createErrorMessage(input, field_name + ' is required.');
             } else {
                 input.classList.remove('error');
                 removeErrorMessage(input);
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
             }
             if (input.name === 'declaration_agree') {
                 if (!input.checked) {
                     input.classList.add('error');
                     isValid = false;
                     showToast('You must accept the declaration to continue.', 'left', 'bottom');
                 } else {
                     input.classList.remove('error');
                 }
             }
         })
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
             form.submit();
         }
     }

     function getFormatedname(elm) {
         if (elm.hasAttribute('data-name')) return elm.getAttribute('data-name');
         return formatFieldName(elm.name)

     }

     function formatFieldName(fieldName) {
         let words;
         if (fieldName.includes('_')) {
             words = fieldName.split('_');
         } else {
             words = [fieldName];
         }
         let capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
         let formattedName = capitalizedWords.join(' ');
         return formattedName;
     }

     function amountValidation(input) {
         const tierSelect = document.querySelector('select[name="tier"]');
         const tier = tierSelect ? tierSelect.value : null;
         const amount = parseInt(input.value);

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

         const limits = tierLimits[tier];

         if (!limits || isNaN(amount) || amount < limits.min || amount > limits.max) {
             const message =
                 `For Tier ${tier}, amount must be between ${limits.min.toLocaleString()} and ${limits.max.toLocaleString()}`;
             createErrorMessage(input, message);
             showToast(message, 'left', 'bottom');
             input.classList.add('error');
             return false;
         }

         input.classList.remove('error');
         removeErrorMessage(input);
         return true;
     }

     function cnicValidation(input, elemName, elemeValue) {
         // Allow both dashed and non-dashed formats
         const cnicRegex = /^(\d{5}-\d{7}-\d{1}|\d{13})$/;

         if (!elemeValue.match(cnicRegex)) {
             input.style.border = '1px solid red';
             showToast("Please enter a valid " + elemName, "left", "bottom");

             // Optional: Show inline error
             removeErrorMessage(input);
             createErrorMessage(input, "Please enter a valid " + elemName);

             return false;
         } else {
             input.classList.remove('error');
             removeErrorMessage(input);
             return true;
         }
     }

     function phoneValidation(input, elemName, elemeValue) {
         // Allow both dashed and non-dashed formats
         const phoneRegex = /^(03\d{9})$/;

         if (!elemeValue.match(phoneRegex)) {
             input.classList.remove('error');
             elemName=getFormatedname(input)

             // Optional: Show inline error
             removeErrorMessage(input);
             createErrorMessage(input, "Please enter a valid " + elemName + " 03XXXXXXXXX");

             return false;
         } else {
             input.classList.remove('error');
             removeErrorMessage(input);
             return true;
         }
     }

     function createErrorMessage(input, message) {
         const inputGroupParent = input.closest('.input-group')?.parentElement;
         if (!inputGroupParent) return;

         // Check if an error div already exists
         let errorDiv = inputGroupParent.querySelector('.input-error-div');

         if (!errorDiv) {
             errorDiv = document.createElement('div');
             errorDiv.className = 'input-error-div';
             inputGroupParent.appendChild(errorDiv);
         }

         errorDiv.textContent = message;
         errorDiv.style.display = 'block';
     }

     function removeErrorMessage(input) {
         const inputGroupParent = input.closest('.input-group')?.parentElement;
         if (!inputGroupParent) return;

         const errorDiv = inputGroupParent.querySelector('.input-error-div');
         if (errorDiv) {
             errorDiv.textContent = '';
             errorDiv.style.display = 'none';
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

     function showToast(msg, pos, grv) {
         // var existingToast = $(".toastify");
         // if (existingToast.length) {
         //     // If the toast div exists, update its content
         //     existingToast.text(msg);
         //     setTimeout(function() {

         //     }, 3000)
         // } else {
         Toastify({
             text: msg,
             duration: 3000,
             // destination: "https://github.com/apvarun/toastify-js",
             newWindow: true,
             // close: true,
             gravity: grv, // `top` or `bottom`
             position: pos, // `left`, `center` or `right`
             stopOnFocus: true, // Prevents dismissing of toast on hover
             style: {
                 background: "linear-gradient(to right, red, red)",
             },
             onClick: function() {} // Callback after click
         }).showToast();
         // }
     }
 </script>
