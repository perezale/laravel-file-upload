@extends('layouts.app')

@section('content')
    <div class="flex flex-col w-full h-screen items-center justify-center bg-grey-lighter">
        <div class="pb-4">
            <form class="flexbox" action="/" enctype="multipart/form-data">

                <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-indigo-800 rounded-lg shadow-lg tracking-wide uppercase border border-indigo-800 cursor-pointer hover:bg-indigo-800 hover:text-white">
                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>
                    <span class="mt-2 text-base leading-normal">Upload a file</span>
                    <input type='file'  id="fileToUpload" name="file" class="hidden" />
                </label>
            </form>
        </div>
        <div class="pb-4 w-1/2 hidden" id="alert">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative hidden" id="errorAlert" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline" id="errorMsg"></span>
            </div>
            <div class="bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded relative hidden" id="uploadAlert role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline" id="uploadMsg"></span>
            </div>
        </div>
        <div class="pb-4 ">
            <button class="bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 border-b-4 border-indigo-700 hover:border-indigo-500 rounded">
                <a href="files">List all files</a>
            </button>
        </div>

    </div>
    <script>
        let alert = document.getElementById("alert");

        let uploadAlert = document.getElementById("uploadAlert");
        let uploadMsg = document.getElementById("uploadMsg");

        let errorAlert = document.getElementById("errorAlert");
        let errorMsg = document.getElementById("errorMsg");

        // Select your input type file and store it in a variable
        const input = document.getElementById('fileToUpload');

        // This will upload the file after having read it
        const upload = (file) => {
            fetch('/', { // Your POST endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: file // This is your file object
            }).then(
                response => response.json() // if the response is a JSON object
            ).then(
                function(success) {
                    console.log(success)
                    if(success.code != 200)
                    {
                        errorMsg.innerText = success.messages.file.toString();
                        alert.classList.remove("hidden");
                        return;
                    }
                    let link = document.createElement("a");
                    link.classList.add("hover:underline");
                    link.innerText = 'Open file';
                    link.href = "/storage/" + success.file;
                    uploadMsg.innerText = "File uploaded OK! ";
                    uploadMsg.innerHTML += link.outerHTML;
                    alert.classList.remove("hidden");

                } // Handle the success response object
            ).catch(
                error => console.log(error) // Handle the error response object
            );
        };

        // Event handler executed when a file is selected
        const onSelectFile = () => {
            alert.classList.add("hidden");
            var form_data = new FormData();
            form_data.append('file', input.files[0]);
            upload(form_data);
        }

        // Add a listener on your input
        // It will be triggered when a file will be selected
        input.addEventListener('change', onSelectFile, false);
    </script>
@endsection
