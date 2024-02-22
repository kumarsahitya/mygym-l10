<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule a class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 text-gray-900">
                    <form action="{{ route('schedule.store') }}" method="post" class="max-w-lg">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="text-sm">Select type of class</label>
                                <select name="class_type_id"
                                    class="block mt-2 w-full border-gray-300 focus:ring-0 focus:border-gray-500">
                                    @foreach ($classTypes as $classType)
                                        <option value="{{ $classType->id }}" {{ (old("class_type_id") == $classType->id ? "selected":"") }}>{{ $classType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-6">
                                <div class="flex-1">
                                    <label class="text-sm">Date</label>
                                    <input type="date" name="date"
                                        class="block mt-2 w-full border-gray-300 focus:ring-0 focus:border-gray-500"
                                        min="{{ date('Y-m-d', strtotime('tomorrow')) }}"
                                        value="{{ old('date') }}">
                                </div>
                                <div class="flex-1">
                                    <label class="text-sm">Time</label>
                                    <select type="time" name="time"
                                        class="block mt-2 w-full border-gray-300 focus:ring-0 focus:border-gray-500">
                                        @php
                                            $time = [
                                                "05:00:00" => "5 am",
                                                "06:00:00" => "6 am",
                                                "07:00:00" => "7 am",
                                                "08:00:00" => "8 am",
                                                "17:00:00" => "5 pm",
                                                "18:00:00" => "6 pm",
                                                "19:00:00" => "7 pm",
                                                "20:00:00" => "8 pm",
                                            ];
                                        @endphp
                                        @foreach ($time as $key => $value)
                                            <option value="{{ $key }}" {{ (old("time") == $key ? "selected":"") }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                @error('date_time')
                                    <div class="text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-primary-button>Schedule</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
