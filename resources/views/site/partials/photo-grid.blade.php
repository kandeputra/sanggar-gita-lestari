<div class="columns-2 gap-4 md:columns-3 lg:columns-4 [&>*]:mb-4">
    @foreach ($items as $item)
        <a href="{{ $item->fileUrl('image') }}" data-lightbox data-title="{{ $item->title }}{{ $item->caption ? ' — '.$item->caption : '' }}"
           class="group relative block break-inside-avoid overflow-hidden rounded-xl">
            <img src="{{ $item->fileUrl('image') }}" alt="{{ $item->title }}" loading="lazy" class="w-full transition duration-500 group-hover:scale-105">
            <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-bata-950/80 p-3 text-sm text-lontar-50 opacity-0 transition group-hover:opacity-100">{{ $item->title }}</span>
        </a>
    @endforeach
</div>

@once
    <dialog id="lightbox" class="m-auto max-h-[92vh] max-w-5xl bg-transparent p-0 backdrop:bg-bata-950/90">
        <figure class="relative">
            <img src="" alt="" class="max-h-[82vh] w-auto rounded-lg">
            <figcaption data-lightbox-caption class="mt-3 text-center text-sm text-lontar-100"></figcaption>
            <button type="button" data-lightbox-close class="absolute right-2 top-2 rounded-full bg-black/60 px-3 py-1 text-lontar-50 hover:bg-black">Tutup ✕</button>
        </figure>
    </dialog>
@endonce
