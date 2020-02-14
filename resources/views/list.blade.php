
@extends('layouts.app')

@section('content')
    <div class="bg-indigo-900 py-4 lg:px-4">
        <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">

                <svg class="fill-current opacity-75 h-4" width="16" transform="scale(-1,1)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
                <span class="font-semibold mr-2 text-left flex-auto"><a href="../">back</a></span>

        </div>
    </div>
    <div class="flex flex-col w-full h-screen items-center pt-4 bg-grey-lighter">
        @foreach($files as $file)
        <div class="w-1/2 py-2 rounded shadow-lg">
            <div class="px-6 py-4">
                <div class="text-gray-700 text-base inline-flex items-center"><img style="width: 16px" src="img/document.svg" alt=""> &nbsp;<a href="/storage/{{ $file->url  }}">{{ $file->url }}</a></div>
            </div>
            <div class="flex justify-between px-6 py-4">
                <div class="">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $file->size }}</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $file->time }}</span>
                </div>
                <div class="">
                    <form action="{{ $file->url }}" method="post">
                        {{ method_field('DELETE') }}
                        @csrf
                        <button type="submit" class="bg-transparent hover:bg-blue-500 text-sm text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endforeach

    </div>
@endsection
