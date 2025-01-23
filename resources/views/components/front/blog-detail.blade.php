<x-front.layout>
    <x-slot name="pageHeader">{{ $data->title }}</x-slot>
    <x-slot name="pageSubHeading">{{ $data->description }}</x-slot>
    <x-slot name="pageBg">{{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION') . '/' . $data->thumbnail) }}</x-slot>
    <x-slot name="pageHeaderLink">{{ route('blog.detail', ['slug' => $data->slug]) }}</x-slot>
    <x-slot name="pageUser">{{ $data->user->name }}</x-slot>
    <x-slot name="pageDate">{{ $data->created_at->isoformat('dddd, D MMMM Y') }}</x-slot>
    <x-slot name="pageTitle">{{ $data->title }}</x-slot>

    {{-- @dd($data->user) --}}
    <!-- Main Content-->
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    {!! $data->content !!}
                    <!-- Pager-->
                    <div class="d-flex justify-content-between mb-4 mt-5">

                        <div class="">
                            <div></div>
                            <a class="btn btn-primary text-uppercase" href="{{ url('/') }}">&larr;Back</a>


                        </div>
                        <div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </article>


</x-front.layout>
