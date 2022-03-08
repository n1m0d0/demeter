@props(['step'])

<div class="w-full py-6">
    <div class="flex">
        <div class="w-1/2">
            <div class="relative mb-2">
                <div class="w-10 h-10 mx-auto bg-indigo-400 rounded-full text-lg text-white flex items-center">
                    <span class="text-center text-white w-full">
                        <x-fas-pencil class="w-10 h-6 text-white" />
                    </span>
                </div>
            </div>

            <div class="text-xs text-center md:text-base">Registrar Pedido</div>
        </div>

        <div class="w-1/2">
            <div class="relative mb-2">
                @if ($step > 1)
                    <div class="absolute flex align-center items-center align-middle content-center"
                        style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                        <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                            <div class="w-0 bg-indigo-300 py-1 rounded" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="w-10 h-10 mx-auto bg-indigo-400 rounded-full text-lg text-white flex items-center">
                        <span class="text-center text-white w-full">
                            <x-fas-folder-open class="w-10 h-6 text-white" />
                        </span>
                    </div>
                @else
                    <div class="absolute flex align-center items-center align-middle content-center"
                        style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                        <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                            <div class="w-0 bg-indigo-300 py-1 rounded" style="width: 0%;"></div>
                        </div>
                    </div>
                    <div
                        class="w-10 h-10 mx-auto bg-white border-2 border-gray-200 rounded-full text-lg text-white flex items-center">
                        <span class="text-center text-gray-600 w-full">
                            <x-fas-folder-open class="w-10 h-6 text-gray-600" />
                        </span>
                    </div>
                @endif
            </div>

            <div class="text-xs text-center md:text-base">Registrar Productos</div>
        </div>

        <div class="w-1/2">
            <div class="relative mb-2">
                @if ($step > 2)
                    <div class="absolute flex align-center items-center align-middle content-center"
                        style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                        <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                            <div class="w-0 bg-indigo-300 py-1 rounded" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="w-10 h-10 mx-auto bg-indigo-400 rounded-full text-lg text-white flex items-center">
                        <span class="text-center text-white w-full">
                            <x-fas-credit-card class="w-10 h-6 text-white" />
                        </span>
                    </div>
                @else
                    <div class="absolute flex align-center items-center align-middle content-center"
                        style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                        <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                            <div class="w-0 bg-indigo-300 py-1 rounded" style="width: 0%;"></div>
                        </div>
                    </div>
                    <div
                        class="w-10 h-10 mx-auto bg-white border-2 border-gray-200 rounded-full text-lg text-white flex items-center">
                        <span class="text-center text-gray-600 w-full">
                            <x-fas-credit-card class="w-10 h-6 text-gray-600" />
                        </span>
                    </div>
                @endif
            </div>

            <div class="text-xs text-center md:text-base">Registrar Saldo</div>
        </div>
    </div>
</div>
