import './bootstrap';
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



 
const inputElement = document.querySelector('input[type="file"].filepond');

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const urlUpload = 'http://127.0.0.1:8000/uploads/tmpupload';
 
FilePond.create(inputElement).setOptions({
    server: {
     url: urlUpload,
     headers: {
         'X-CSRF-TOKEN': csrfToken,
     }

   }
});