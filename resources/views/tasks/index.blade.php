<x-app-layout>
    <!-- ... existing header code ... -->

    <div class="max-w-6xl mx-auto p-4">
        <!-- ... existing create button ... -->

        <div class="space-y-4">
            @foreach($tasks as $task)
                <div class="bg-white p-6 shadow rounded-lg relative">
                    <!-- Deadline reminder badge (absolute positioned) -->
                    @if($task->deadline)
                        @php
                            $daysUntilDue = \Carbon\Carbon::parse($task->deadline)->diffInDays(now(), false);
                        @endphp
                        <div class="absolute top-4 right-4">
                            <span class="px-2 py-1 text-xs font-medium rounded 
                                @if($daysUntilDue > 0) bg-red-100 text-red-800
                                @elseif($daysUntilDue == 0) bg-orange-100 text-orange-800
                                @elseif($daysUntilDue >= -3) bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($daysUntilDue > 0)
                                    Overdue by {{ abs($daysUntilDue) }} day{{ abs($daysUntilDue) > 1 ? 's' : '' }}
                                @elseif($daysUntilDue == 0)
                                    Due today
                                @else
                                    Due in {{ abs($daysUntilDue) }} day{{ abs($daysUntilDue) > 1 ? 's' : '' }}
                                @endif
                            </span>
                        </div>
                    @endif

                    <!-- ... rest of your task card content ... -->
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">
                                <span class="font-medium">Assigned To:</span> 
                                {{ $task->user->name ?? 'Unassigned' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">
                                <span class="font-medium">Deadline:</span> 
                                <span class="@if($task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast()) text-red-600 font-medium @endif">
                                    {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('M j, Y g:i a') : 'None' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>