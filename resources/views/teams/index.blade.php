@extends('layouts.web')
@section('title')
Team {{ $team->name }}
@endsection
@section('content')
<div class="h-full flex flex-col mx-4" id="team">
    <div class="card mt-6 flex flex-col p-3 w-full lg:w-1/2 self-center">
        <div class="flex self-center flex-col justify-center items-center">
            <button class="px-2 py-1 hover:bg-gray-100 rounded">
                <img src="{{ $team->logo_url }}" class="w-10 h-10 self-center" alt="organization_avatar">
                <input type="file" name="logo" accept="image/*" ref="logo" id="logo" class="hidden">
            </button>
            <p class="text-xl text-gray-600"> @{{ team.name  }} </p>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    new Vue({
        el : '#team',
        data : {
            team : @json($team)
        },
        methods : {
            selectFile() {
                this.$refs.logo.click()
            },
            uploadFile() {
                let file = this.$refs.logo.files[0];
                if (file) {

                }
            }
        }
    })
</script>
@endsection
