@extends('layouts.web')

@section('title')
Notifications
@endsection

@section('content')
<div class="h-full flex flex-col mx-2 justify-center items-center" id="notifications">
    @if ($notifications->count() > 0 )
    @foreach ($notifications as $notification)
    <div class="card rounded flex-col shadow-sm mt-2 py-3 pr-3 border-l-8 border-gray-400 lg:w-1/2">
        <div class="flex flex-col lg:flex-row pl-2 justify-between w-full items-center">
            <span class="text-gray-600"> {{ $notification->data['text'] }} </span>
            <span class="text-gray-400 text-xs"> {{ $notification->created_at->diffForHumans() }} </span>
            <a href="{{ $notification->data['url'] ?? '#' }}"
                class="text-right text-gray-600 justify-around self-end flex rounded hover:bg-gray-200 p-1">
                <span> View </span>
                <svg version="1.1" class="stroke-current h-6 w-6 text-gray-600  ml-1" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

                    <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                        <path d="M19,12h-14"></path>
                        <path d="M14,17l5,-5"></path>
                        <path d="M14,7l5,5"></path>
                    </g>
                </svg>
            </a>
        </div>
    </div>
    @endforeach
    @else
    <h4 class="text-lg text-gray-600 mt-6 text-center tracking-wide"> No Notifications </h4>
    <svg xmlns="http://www.w3.org/2000/svg" class="w-10/12 lg:w-1/2" viewBox="0 0 1613 1404">
        <g id="Group_1" data-name="Group 1" transform="translate(-3355 820.5)">
            <g id="Background_Object_Window_4" data-name="Background Object / Window / 4"
                transform="translate(3792 -820.5)">
                <g id="Group_36" data-name="Group 36" transform="translate(87 87)">
                    <path id="Stroke_1" data-name="Stroke 1" d="M.5,0V376.531" transform="translate(301.514 61.718)"
                        fill="none" stroke="#b6d4ff" stroke-miterlimit="10" stroke-width="18" />
                    <path id="Stroke_2" data-name="Stroke 2" d="M.5,0V376.531" transform="translate(492.273 61.718)"
                        fill="none" stroke="#b6d4ff" stroke-miterlimit="10" stroke-width="18" />
                    <path id="Stroke_3" data-name="Stroke 3" d="M.5,0V376.531" transform="translate(125.504 61.718)"
                        fill="none" stroke="#b6d4ff" stroke-miterlimit="10" stroke-width="18" />
                    <path id="Fill_4" data-name="Fill 4" d="M0,394.871H18.142V0H0Z" transform="translate(660.109 52.547)"
                        fill="#b6d4ff" />
                    <path id="Fill_5" data-name="Fill 5" d="M558.028,394.872H0V0H558.028V394.871ZM17,17V377.871H541.028V17Z"
                        transform="translate(110.086 52.547)" fill="#dceeff" />
                    <path id="Fill_6" data-name="Fill 6" d="M0,18.194H543.552V0H0Z" transform="translate(93.784 447.417)"
                        fill="#cce3ff" />
                    <path id="Fill_7" data-name="Fill 7" d="M0,18.194H45.548V0H0Z" transform="translate(637.335 447.417)"
                        fill="#b6d4ff" />
                    <path id="Stroke_8" data-name="Stroke 8" d="M.5,0V384.773" transform="translate(293.22 57.597)"
                        fill="none" stroke="#dceeff" stroke-miterlimit="10" stroke-width="16" />
                    <path id="Stroke_9" data-name="Stroke 9" d="M.5,0V384.773" transform="translate(483.979 57.597)"
                        fill="none" stroke="#dceeff" stroke-miterlimit="10" stroke-width="16" />
                    <path id="Stroke_10" data-name="Stroke 10" d="M0,.5H533.462" transform="translate(119.561 249.482)"
                        fill="none" stroke="#dceeff" stroke-miterlimit="10" stroke-width="16" />
                    <path id="Fill_11" data-name="Fill 11" d="M117.485,330.146C117.485,160.718,29.944,0,29.944,0H0V330.146Z"
                        transform="translate(67.914 211.426)" fill="#cce3ff" />
                    <path id="Fill_13" data-name="Fill 13" d="M117.485,0c0,102.823-87.541,200.359-87.541,200.359H0V0Z"
                        transform="translate(67.914 11.067)" fill="#cce3ff" />
                    <path id="Fill_15" data-name="Fill 15" d="M53.619,26.268,0,28.595V0L53.619,2.327Z"
                        transform="translate(56.999 199.601)" fill="#ecf6ff" />
                    <path id="Fill_17" data-name="Fill 17" d="M0,330.146C0,160.718,84.07,0,84.07,0h28.758V330.146Z"
                        transform="translate(594.387 211.426)" fill="#cce3ff" />
                    <path id="Fill_19" data-name="Fill 19" d="M0,0C0,102.823,84.07,200.359,84.07,200.359h28.758V0Z"
                        transform="translate(594.387 11.067)" fill="#cce3ff" />
                    <path id="Fill_21" data-name="Fill 21" d="M0,26.269,50.107,28.6V0L0,2.328Z"
                        transform="translate(665.31 199.6)" fill="#ecf6ff" />
                    <path id="Fill_23" data-name="Fill 23" d="M0,15.006H733.646V0H0Z" transform="translate(18.569 11.067)"
                        fill="#cce3ff" />
                    <path id="Fill_25" data-name="Fill 25"
                        d="M10.542,114.859h0A10.573,10.573,0,0,1,0,104.318V10.541a10.542,10.542,0,0,1,21.083,0v93.777a10.572,10.572,0,0,1-10.541,10.541"
                        transform="translate(409.504 305.783)" fill="#cce3ff" />
                    <path id="Fill_26" data-name="Fill 26"
                        d="M5.673,11.629H29.788a5.691,5.691,0,0,0,5.674-5.673V5.672A5.69,5.69,0,0,0,29.788,0H5.673A5.689,5.689,0,0,0,0,5.672v.284a5.69,5.69,0,0,0,5.673,5.673"
                        transform="translate(387.274 345.852)" fill="#cce3ff" />
                    <path id="Fill_27" data-name="Fill 27"
                        d="M6.884,33.646h0A6.9,6.9,0,0,1,0,26.762V6.884A6.9,6.9,0,0,1,6.883,0h0a6.9,6.9,0,0,1,6.883,6.884V26.762a6.9,6.9,0,0,1-6.883,6.884"
                        transform="translate(387.274 323.835)" fill="#cce3ff" />
                    <path id="Fill_28" data-name="Fill 28"
                        d="M28.287,14.766H5.673A5.69,5.69,0,0,1,0,9.093V5.673A5.69,5.69,0,0,1,5.673,0H28.287A5.69,5.69,0,0,1,33.96,5.673v3.42a5.69,5.69,0,0,1-5.673,5.673"
                        transform="translate(420.519 373.783)" fill="#cce3ff" />
                    <path id="Fill_29" data-name="Fill 29"
                        d="M6.114,34.248H7.07a6.132,6.132,0,0,0,6.114-6.115V6.115A6.133,6.133,0,0,0,7.07,0H6.114A6.133,6.133,0,0,0,0,6.115V28.133a6.132,6.132,0,0,0,6.114,6.115"
                        transform="translate(441.295 354.301)" fill="#cce3ff" />
                    <path id="Fill_30" data-name="Fill 30" d="M0,0H59.247L52.992,46.679H6.255Z"
                        transform="translate(392.336 400.642)" fill="#b6d4ff" />
                    <path id="Fill_31" data-name="Fill 31"
                        d="M3.04,10.55A21.587,21.587,0,1,0,32.631,3.04,21.587,21.587,0,0,0,3.04,10.55"
                        transform="translate(517.842 404.953)" fill="#b6d4ff" />
                    <path id="Fill_32" data-name="Fill 32"
                        d="M.8,14.851c2.424,7.111,10.185,10.9,10.185,10.9S14.819,18.012,12.4,10.9,2.211,0,2.211,0-1.62,7.74.8,14.851"
                        transform="translate(527.335 382.694)" fill="#b6d4ff" />
                    <path id="Fill_33" data-name="Fill 33" d="M35.14,17.569,17.571,35.139,0,17.569,17.571,0Z"
                        transform="translate(0.999 1.001)" fill="#cce3ff" />
                    <path id="Fill_34" data-name="Fill 34" d="M35.139,17.57,17.57,35.14,0,17.57,17.57,0Z"
                        transform="translate(734.646 2.815)" fill="#cce3ff" />
                </g>
            </g>
            <g id="Background_Object_Sofa_3" data-name="Background Object / Sofa / 3" transform="translate(3355 -666.5)">
                <g id="Group_20" data-name="Group 20" transform="translate(182 398)">
                    <path id="Fill_1" data-name="Fill 1" d="M0,133.672H564.375V0H0Z" transform="translate(230.641 197.507)"
                        fill="#b6d4ff" />
                    <path id="Fill_2" data-name="Fill 2"
                        d="M40.893,224.794H447.781a40.89,40.89,0,0,0,40.729-37.267L501.235,44.514A40.891,40.891,0,0,0,460.505,0H53.617a40.891,40.891,0,0,0-40.73,37.267L.164,180.28a40.89,40.89,0,0,0,40.729,44.514"
                        transform="translate(348.081 1)" fill="#b6d4ff" />
                    <path id="Fill_4-2" data-name="Fill 4"
                        d="M53.075,231.975H211.436a39.962,39.962,0,0,0,39.814-43.4L238.14,36.529A39.961,39.961,0,0,0,198.327,0H39.966A39.962,39.962,0,0,0,.151,43.394l13.11,152.052a39.962,39.962,0,0,0,39.814,36.529"
                        transform="translate(0.999 164.149)" fill="#b6d4ff" />
                    <path id="Fill_7-2" data-name="Fill 7"
                        d="M40.894,224.794H492.923a40.891,40.891,0,0,0,40.73-37.267L546.376,44.514A40.89,40.89,0,0,0,505.647,0H53.618a40.891,40.891,0,0,0-40.73,37.267L.164,180.28a40.891,40.891,0,0,0,40.73,44.514"
                        transform="translate(225.661 1)" fill="#dceeff" />
                    <path id="Fill_9" data-name="Fill 9" d="M0,70H690.239V0H0Z" transform="translate(70.794 326.122)"
                        fill="#cce3ff" />
                    <path id="Fill_11-2" data-name="Fill 11"
                        d="M43.67,87.34H529.3A43.67,43.67,0,1,0,529.3,0H43.67a43.67,43.67,0,0,0,0,87.34"
                        transform="translate(121.359 238.782)" fill="#dceeff" />
                    <path id="Fill_12" data-name="Fill 12" d="M21,56.716H37.564L30.564,0H0Z"
                        transform="translate(871.204 396.124)" fill="#b6d4ff" />
                    <path id="Fill_13-2" data-name="Fill 13" d="M21,56.716H37.563L30.563,0H0Z"
                        transform="translate(728.846 396.124)" fill="#b6d4ff" />
                    <path id="Fill_14" data-name="Fill 14" d="M16.563,56.716H0L7,0H37.563Z"
                        transform="translate(56.846 396.124)" fill="#b6d4ff" />
                    <path id="Fill_15-2" data-name="Fill 15" d="M16.564,56.716H0L7,0H37.564Z"
                        transform="translate(199.204 396.124)" fill="#b6d4ff" />
                    <path id="Fill_16" data-name="Fill 16"
                        d="M53.075,231.975H76.8a39.962,39.962,0,0,0,39.815-43.4L103.51,36.529A39.963,39.963,0,0,0,63.695,0H39.966A39.962,39.962,0,0,0,.151,43.394l13.11,152.052a39.962,39.962,0,0,0,39.814,36.529"
                        transform="translate(0.999 164.149)" fill="#cce3ff" />
                    <path id="Fill_17-2" data-name="Fill 17"
                        d="M39.964,231.975H218.325a39.961,39.961,0,0,0,39.814-36.529L271.248,43.394A39.96,39.96,0,0,0,231.435,0H53.073A39.961,39.961,0,0,0,13.26,36.529L.151,188.58a39.96,39.96,0,0,0,39.813,43.4"
                        transform="translate(697.924 164.149)" fill="#b6d4ff" />
                    <path id="Fill_18" data-name="Fill 18"
                        d="M39.964,231.975H63.693a39.961,39.961,0,0,0,39.815-36.529L116.617,43.394A39.961,39.961,0,0,0,76.8,0H53.073A39.961,39.961,0,0,0,13.26,36.529L.151,188.58a39.96,39.96,0,0,0,39.813,43.4"
                        transform="translate(697.924 164.149)" fill="#cce3ff" />
                </g>
            </g>
            <g id="Background_Object_Lamp" data-name="Background Object / Lamp" transform="translate(4023 -527.5)">
                <g id="Group_17" data-name="Group 17" transform="translate(263 31)">
                    <path id="Stroke_1-2" data-name="Stroke 1"
                        d="M0,19.345S3.956-1.259,17.469.061C45.66,2.817,11.131,93.395,69.141,99.212s64.033-84.92,64.033-84.92"
                        transform="translate(285.55 164.59)" fill="none" stroke="#cce3ff" stroke-miterlimit="10"
                        stroke-width="7" />
                    <path id="Stroke_3-2" data-name="Stroke 3" d="M.5,0V529.7" transform="translate(287.135 123.62)"
                        fill="none" stroke="#dceeff" stroke-miterlimit="10" stroke-width="15" />
                    <path id="Stroke_5" data-name="Stroke 5" d="M346.17,149.217,0,0" transform="translate(72.554 29.665)"
                        fill="none" stroke="#dceeff" stroke-miterlimit="10" stroke-width="15" />
                    <path id="Fill_7-3" data-name="Fill 7"
                        d="M0,21.935H133.334V15.371A15.371,15.371,0,0,0,117.963,0H15.37A15.371,15.371,0,0,0,0,15.371Z"
                        transform="translate(220.968 631.384)" fill="#dceeff" />
                    <path id="Fill_10" data-name="Fill 10" d="M0,30.353l113.442,24.7,3.668-31.7L9.841,0Z"
                        transform="translate(0 75.424)" fill="#b6d4ff" />
                    <path id="Fill_12-2" data-name="Fill 12"
                        d="M0,57.292l33.821,7.363,9.656-44.348A16.438,16.438,0,0,0,30.913.751L29.21.38A16.436,16.436,0,0,0,9.654,12.944Z"
                        transform="translate(50.709 0.999)" fill="#b6d4ff" />
                    <path id="Fill_15-3" data-name="Fill 15" d="M107.27,49.5,73.616,5.369,48.956,0,0,26.149Z"
                        transform="translate(9.841 49.275)" fill="#b6d4ff" />
                </g>
            </g>
        </g>
    </svg>
    @endif
    {{ $notifications->links() }}
    {{ $notifications->links('components.simple-paginate')}}
</div>
@endsection
