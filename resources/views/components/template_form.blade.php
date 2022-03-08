<div class="p-2 grid grid-cols-1 md:grid-cols-12 gap-4">
    <div class="flex col-span-1 md:col-span-12 items-center gap-2">
        {{ $search }}
    </div>
    <div class="col-span-1 md:col-span-4 border-2 p-2">
        {{ $form }}
    </div>
    <div class="col-span-1 md:col-span-8 border-2 p-2">
        <div class="overflow-x-auto">
            {{ $table }}
        </div>
        {{ $paginate }}
    </div>
</div>