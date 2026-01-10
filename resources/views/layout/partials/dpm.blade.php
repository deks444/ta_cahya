<div id="activities" class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Grid -->
    <div class="grid md:grid-cols-2 gap-12">
        <div class="lg:w-3/4">
            <h2 class="text-3xl text-gray-800 font-bold lg:text-4xl">
                Daftar Kegiatan Sharefit
                <br>
                Bergabunglah Bersama Kami
            </h2>
            <p class="mt-3 text-gray-800">
                Kami menyediakan berbagai program latihan dan kegiatan olahraga yang dirancang untuk meningkatkan
                kebugaran dan kesehatan Anda secara menyeluruh.
            </p>
        </div>
        <!-- End Col -->

        <div class="space-y-6 lg:space-y-10">
            @if(isset($activities) && count($activities) > 0)
                @foreach($activities as $activity)
                    <!-- Icon Block -->
                    <div class="flex gap-x-5 sm:gap-x-8">
                        <!-- Icon -->
                        <span
                            class="shrink-0 inline-flex justify-center items-center size-[46px] rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm mx-auto overflow-hidden">
                            @if($activity->icon)
                                <img src="{{ asset($activity->icon) }}" class="w-6 h-6 object-contain" alt="Icon">
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            @endif
                        </span>
                        <div class="grow">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                {{ $activity->name }}
                            </h3>
                            <p class="mt-1 text-gray-600">
                                {{ $activity->description }}
                            </p>
                        </div>
                    </div>
                    <!-- End Icon Block -->
                @endforeach
            @else
                <p class="text-gray-500">Belum ada data kegiatan untuk saat ini.</p>
            @endif
        </div>
        <!-- End Col -->
    </div>
    <!-- End Grid -->
</div>
<!-- End Icon Blocks -->