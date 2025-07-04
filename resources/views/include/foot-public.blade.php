 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

 <script>
     $(document).ready(function() {
         $('input[name="cnic"]').mask('00000-0000000-0');
         $('input[name="phone"]').mask('00000000000');
     });

     function validateForm(event, form, id) {
         console.log('validate')
         event.preventDefault();
         var inputs = form.querySelectorAll('input');
         var selects = form.querySelectorAll('select');
         var isValid = true;
         selects.forEach(function(select) {
             console.log(select.value)
             if (!select.value || select.value === '') {
                 select.classList.add('error');
                 isValid = false;
                 field_name = formatFieldName(select.name)
                 showToast(field_name + ' required.', 'left', 'bottom');
             }
         })
         inputs.forEach(function(input) {
             if (input.value.trim() === '') {
                 input.classList.add('error');
                 isValid = false;
                 field_name = formatFieldName(input.name)
                 // removeErrorComponent(input);
                 // createErrorComponent(input, '' + field_name + ' required.', '');
                 showToast(field_name + ' required.', 'left', 'bottom');
             } else {
                 input.classList.remove('error');
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

     function cnicValidation(input, elemName, elemeValue) {
         // Allow both dashed and non-dashed formats
         const cnicRegex = /^(\d{5}-\d{7}-\d{1}|\d{13})$/;

         if (!elemeValue.match(cnicRegex)) {
             input.style.border = '1px solid red';
             showToast("Please enter a valid " + elemName, "left", "bottom");

             // Optional: Show inline error
             // removeErrorComponent(input);
             // createErrorComponent(input, elemName + ' is invalid.', '');

             return false;
         } else {
             input.classList.remove('error');
             // removeErrorComponent(input);
             return true;
         }
     }

     function phoneValidation(input, elemName, elemeValue) {
         // Allow both dashed and non-dashed formats
         const phoneRegex = /^(03\d{9})$/;

         if (!elemeValue.match(phoneRegex)) {
             input.style.border = '1px solid red';
             showToast("Please enter a valid " + elemName, "left", "bottom");

             // Optional: Show inline error
             // removeErrorComponent(input);
             // createErrorComponent(input, elemName + ' is invalid.', '');

             return false;
         } else {
             input.classList.remove('error');
             // removeErrorComponent(input);
             return true;
         }
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
