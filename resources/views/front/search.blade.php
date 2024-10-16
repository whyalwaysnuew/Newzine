@extends('front.master')

@section('content')
        <body class="font-[Poppins]">

            <x-navbar/>

            <nav id="Category" class="max-w-[1130px] mx-auto flex justify-center items-center gap-4 mt-[30px]">
                @foreach ($categories as $item)
                    <a href="{{route('front.category', $item->slug)}}" class="rounded-full p-[12px_22px] flex gap-[10px] font-semibold transition-all duration-300 border border-[#EEF0F7] hover:ring-2 hover:ring-[#FF6B18]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{Storage::url($item->icon)}}" alt="{{$item->slug}}" />
                        </div>
                        <span>{{$item->name}}</span>
                    </a>
                @endforeach
            </nav>

            <section id="heading" class="max-w-[1130px] mx-auto flex items-center flex-col gap-[30px] mt-[70px]">
                <h1 class="text-4xl leading-[45px] font-bold text-center">
                    Explore Hot Trending <br />
                    Good News Today
                </h1>
                <form method="POST" action="{{route('front.search')}}" class="w-[450px] flex items-center rounded-full border border-[#E8EBF4] p-[12px_20px] gap-[10px] focus-within:ring-2 focus-within:ring-[#FF6B18] transition-all duration-300">
                        @csrf
                        <button type="submit" class="w-5 h-5 flex shrink-0">
                            <img src="{{asset('assets/images/icons/search-normal.svg')}}" alt="icon" />
                        </button>
                        <input
                            autocomplete="off"
                            type="text"
                            id="keyword"
                            name="keyword"
                            placeholder="Search hot trendy news today..."
                            class="appearance-none font-semibold placeholder:font-normal placeholder:text-[#A3A6AE] outline-none focus:ring-0 w-full"
                        />
                </form>
            </section>

            <section id="search-result" class="max-w-[1130px] mx-auto flex items-start flex-col gap-[30px] mt-[70px] mb-[100px]">
                <h2 class="text-[26px] leading-[39px] font-bold">Search Result: <span>{{$keyword}}</span></h2>
                <div id="search-cards" class="grid grid-cols-3 gap-[30px]">
                    @forelse ($articles as $news)
                        <a href="{{route('front.details', $news->slug)}}" class="card">
                            <div
                                class="flex flex-col gap-4 p-[26px_20px] transition-all duration-300 ring-1 ring-[#EEF0F7] hover:ring-2 hover:ring-[#FF6B18] rounded-[20px] overflow-hidden bg-white">
                                <div class="thumbnail-container h-[200px] relative rounded-[20px] overflow-hidden">
                                    <div
                                        class="badge absolute left-5 top-5 bottom-auto right-auto flex p-[8px_18px] bg-white rounded-[50px]">
                                        <p class="text-xs leading-[18px] font-bold uppercase">{{$news->category->name}}</p>
                                    </div>
                                    <img src="{{Storage::url($news->thumbnail)}}" alt="thumbnail photo"
                                        class="w-full h-full object-cover" />
                                </div>
                                <div class="flex flex-col gap-[6px]">
                                    <h3 class="text-lg leading-[27px] font-bold">
                                        {{substr($news->name, 0, 30)}}{{strlen($news->name) > 30 ? '...' : ''}}
                                    </h3>
                                    <p class="text-sm leading-[21px] text-[#A3A6AE]">{{$news->created_at->format('d F Y')}}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>Belum ada berita terkait keyword berikut</p>
                    @endforelse
                </div>
            </section>
        </body>
@endsection

@push('after-scripts')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush
