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
        <div class="pb-4">
            <a href="files">
                <div class="p-2 bg-indigo-500 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                    <span class="font-semibold mr-2 text-left flex-auto px-2" id="uploadMsg">List files</span>
                    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
                </div>
            </a>
        </div>

    </div>
    <script>
        let uploadMsg = document.getElementById("uploadMsg");

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
                success => {
                    console.log(success)
                    let link = document.createElement("a");
                    link.innerText = success.link;
                    link.href = "/storage/" + success.link;
                    uploadMsg.innerHTML = "Archivo cargado exitosamente! " + link.outerHTML;
                } // Handle the success response object
            ).catch(
                error => console.log(error) // Handle the error response object
            );
        };

        // Event handler executed when a file is selected
        const onSelectFile = () => {
            var form_data = new FormData();
            form_data.append('file', input.files[0]);
            upload(form_data);
        }

        // Add a listener on your input
        // It will be triggered when a file will be selected
        input.addEventListener('change', onSelectFile, false);
    </script>
@endsection
