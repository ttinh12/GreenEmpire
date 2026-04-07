<x-filament-panels::page>

    {{-- FILTERS --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <select wire:model.live="filterAssignee"
            class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm px-3 py-2 text-gray-700 dark:text-gray-200">
            <option value="">👤 Tất cả người thực hiện</option>
            @foreach ($this->getUsers() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterCustomer"
            class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm px-3 py-2 text-gray-700 dark:text-gray-200">
            <option value="">🏢 Tất cả khách hàng</option>
            @foreach ($this->getCustomers() as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterPriority"
            class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm px-3 py-2 text-gray-700 dark:text-gray-200">
            <option value="">🚦 Tất cả ưu tiên</option>
            @foreach (\App\Models\Task::priorityLabels() as $val => $label)
                <option value="{{ $val }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    {{-- KANBAN BOARD --}}
    <div style="display:flex; flex-direction:row; gap:16px; overflow-x:auto; padding-bottom:24px; min-height:70vh; align-items:flex-start;"
        x-data="{
            draggingId: null,
            draggingStatus: null,
            dragStart(taskId, status, el) {
                this.draggingId = taskId;
                this.draggingStatus = status;
                el.style.opacity = '0.4';
            },
            dragEnd(el) {
                el.style.opacity = '1';
            },
            dragOver(e) {
                e.preventDefault();
                e.currentTarget.style.background = 'rgba(var(--color-primary-500), 0.08)';
            },
            dragLeave(e) {
                e.currentTarget.style.background = '';
            },
            drop(e, newStatus) {
                e.currentTarget.style.background = '';
                if (this.draggingId && this.draggingStatus !== newStatus) {
                    $wire.moveTask(this.draggingId, newStatus);
                }
                this.draggingId = null;
                this.draggingStatus = null;
            }
        }">

        @php $allTasks = $this->getTasks(); @endphp

        @foreach ($this->getStatuses() as $statusId => $statusInfo)
            @php $columnTasks = $allTasks->get($statusId, collect()); @endphp

            {{-- COLUMN --}}
            <div style="flex-shrink:0; width:288px; min-width:288px;">

                {{-- Column Header --}}
                <div
                    style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; padding:0 4px;">
                    <span
                        style="font-weight:600; font-size:14px; color:
                        @if ($statusInfo['color'] === 'gray') #9ca3af
                        @elseif($statusInfo['color'] === 'amber') #f59e0b
                        @elseif($statusInfo['color'] === 'blue') #3b82f6
                        @else #10b981 @endif;">
                        {{ $statusInfo['label'] }}
                    </span>
                    <span
                        style="font-size:12px; background:#374151; color:#9ca3af; border-radius:9999px; padding:2px 10px;">
                        {{ $columnTasks->count() }}
                    </span>
                </div>

                {{-- Drop Zone --}}
                <div style="background:#1f2937; border-radius:12px; padding:8px; min-height:200px;"
                    @dragover="dragOver($event)" @dragleave="dragLeave($event)"
                    @drop="drop($event, {{ $statusId }})">

                    @forelse($columnTasks as $task)
                        {{-- CARD --}}
                        <div draggable="true"
                            style="background:#111827; border-radius:10px; padding:12px; margin-bottom:8px;
                                    border:1px solid #374151; cursor:grab; transition:all 0.15s;"
                            @dragstart="dragStart({{ $task->id }}, {{ $task->status }}, $el)"
                            @dragend="dragEnd($el)" onmouseover="this.style.borderColor='#f97316'"
                            onmouseout="this.style.borderColor='#374151'">

                            {{-- Priority + Due Date --}}
                            <div
                                style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span
                                    style="font-size:11px; border-radius:9999px; padding:2px 8px; font-weight:500;
                                    @if ($task->priority == 4) background:#450a0a; color:#f87171;
                                    @elseif($task->priority == 3) background:#431407; color:#fb923c;
                                    @elseif($task->priority == 2) background:#172554; color:#60a5fa;
                                    @else background:#1f2937; color:#9ca3af; @endif">
                                    {{ $task->priority_label }}
                                </span>
                                @if ($task->due_date)
                                    <span
                                        style="font-size:11px; color:{{ $task->due_date->isPast() && $task->status != 4 ? '#f87171' : '#6b7280' }};">
                                        📅 {{ $task->due_date->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <p
                                style="font-size:14px; font-weight:600; color:#f3f4f6; margin-bottom:6px; line-height:1.4;">
                                {{ $task->title }}
                            </p>

                            {{-- Description --}}
                            @if ($task->description)
                                <p
                                    style="font-size:12px; color:#6b7280; margin-bottom:6px; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                                    {{ $task->description }}
                                </p>
                            @endif

                            {{-- Customer --}}
                            @if ($task->customer)
                                <p style="font-size:12px; color:#6b7280; margin-bottom:4px;">
                                    🏢 {{ $task->customer->name }}
                                </p>
                            @endif

                            {{-- Track Time --}}
                            @if ($task->started_at)
                                <p style="font-size:12px; color:#6b7280; margin-bottom:6px;">
                                    ⏱ {{ $task->duration }}
                                </p>
                            @endif

                            {{-- Footer --}}
                            <div
                                style="display:flex; align-items:center; justify-content:space-between; margin-top:8px; padding-top:8px; border-top:1px solid #1f2937;">
                                @if ($task->assignee)
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <div
                                            style="width:24px; height:24px; border-radius:50%; background:#f97316;
                                                    display:flex; align-items:center; justify-content:center;
                                                    color:white; font-size:11px; font-weight:bold;">
                                            {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                        </div>
                                        <span
                                            style="font-size:12px; color:#9ca3af; max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            {{ $task->assignee->name }}
                                        </span>
                                    </div>
                                @else
                                    <span style="font-size:12px; color:#4b5563;">Chưa assign</span>
                                @endif

                                <a href="{{ \App\Filament\Resources\Tasks\TaskResource::getUrl('edit', ['record' => $task->id]) }}"
                                    style="font-size:12px; color:#f97316; text-decoration:none;"
                                    onmouseover="this.style.textDecoration='underline'"
                                    onmouseout="this.style.textDecoration='none'">
                                    ✏️ Sửa
                                </a>
                            </div>
                        </div>

                    @empty
                        <div style="text-align:center; padding:32px 16px; color:#4b5563; font-size:13px;">
                            Không có task nào
                        </div>
                    @endforelse

                </div>
            </div>
        @endforeach
    </div>

</x-filament-panels::page>
