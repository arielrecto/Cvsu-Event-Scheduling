<x-dashboard.base>
    <div class="panel">
        <x-dashboard.header :route="route('events.show', ['event' => $event->id])" :event_name="'Evaluation From Create - ' . $event->name" />

        <x-notification-message />

        @php
            $hosts = json_encode($event->hosts()->with('speaker')->get());
        @endphp

        <div x-data="evaluationFormGenerator" x-init="addSpeakersDefault({{ $hosts }})" class="flex flex-col gap-2">
            <p class="input-generic-label">
                <span>*</span>
                sample text
            </p>

            <div class="w-full flex justify-center bg-base-100 rounded-lg p-5">
                <h1 class="font-bold text-3xl tracking-widest" x-text="form.title"></h1>
            </div>

            <div class="w-full flex justify-end items-center ">
                <button class="btn-generic" @click="titleToggle = !titleToggle"><span
                        x-text="titleToggle ? 'close' : 'edit'"></span></button>
            </div>


            <div class="input-generic-div" x-show="titleToggle">
                <label for="" class="input-generic-label">Title</label>
                <input type="text" class="input-generic" x-model.debounce="form.title"
                    placeholder="Ex: Sample Title">
                {{-- <div class="w-full flex justify-end">
                    <button class="btn-generic">Add</button>
                </div> --}}
            </div>


            <div class="flex flex-col gap-5 w-full">
                <div class="flex items-center justify-end">
                    <button class="btn-generic" @click="fieldToggle = !fieldToggle"
                        x-text="fieldToggle ? 'Close' : 'Add Field'"></button>
                </div>
                <div x-show="fieldToggle" class="flex flex-col gap-2 bg-base-100 p-5 rounded-lg">
                    <label for="" class="input-generic-label"><span>*</span> Set Question and type of
                        input</label>
                    <div class="input-generic-div">
                        <label for="" class="input-generic-label">Question</label>
                        <input type="text" x-model="fieldBlueprint.question" class="input-generic">
                        <label for="" class="input-generic-label">Input Type</label>
                        <select x-model="fieldBlueprint.input_type" @change="checkInputTypeField($event)"
                            class="select select-accent w-full">
                            <option disabled selected>Select</option>
                            <option value="text">Text</option>
                            {{-- <option value="number">Number</option> --}}
                            <option value="radio">Radio</option>
                            {{-- <option>Light mode</option> --}}
                        </select>

                        <template x-if="fieldBlueprint.input_type === 'radio'">
                            <div class="flex flex-col gap-2">
                                <label for="" class="input-generic-label">Radio Range</label>
                                <input type="text" x-model="fieldBlueprint.radio_max" class="input-generic">
                            </div>
                        </template>
                        <button @click="addField" class="btn btn-accent">Add input</button>
                    </div>
                </div>
            </div>

            <template x-for="field in form.fields" :key="field.localId">
                <div class="flex items-center justify-between">
                    <div class="input-generic-div w-full">
                        <label for="" class="input-generic-label" x-text="field.question"></label>
                        <template x-if="field.input_type !== 'radio'">
                            <input :type="field.input_type" class="input-generic">
                        </template>

                        <template x-if="field.input_type === 'radio'">
                            <div class="flex items-center gap-5">
                                <template x-for="i in parseInt(field.radio_max)" :key="i">
                                    <div class="flex flex-col items-center">
                                        <input type="radio" name="radio-4" class="radio radio-accent"
                                            :value="i" />
                                        <span x-text="i"></span>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <div class="flex items-center justify-end gap-2">
                            <button class="btn btn-xs btn-primary" @click="() => editFieldId = field.localId"><i
                                    class="fi fi-rr-edit"></i></button>
                            <button class="btn btn-xs btn-error" @click="removeField(field.localId)">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </div>

                        <div class="input-generic-div" x-show="editFieldId === field.localId">
                            <div class="w-full flex items-center justify-between">
                                <label for="" class="input-generic-label">Question</label>
                                <button @click="() => editFieldId = null" class="btn btn-xs btn-error"><i
                                        class="fi fi-rr-cross"></i></button>
                            </div>

                            <input type="text" x-model="field.question" class="input-generic">
                            <label for="" class="input-generic-label">Input Type</label>
                            <select x-model="field.input_type" @change="checkInputTypeField($event)"
                                class="select select-accent w-full">
                                <option disabled selected>Select</option>
                                <option value="text">Text</option>
                                {{-- <option value="number">Number</option> --}}
                                {{-- <option value="radio">Radio</option> --}}
                                {{-- <option>Light mode</option> --}}
                            </select>

                            <template x-if="field.input_type === 'radio'">
                                <div class="flex flex-col gap-2">
                                    <label for="" class="input-generic-label">Radio Range</label>
                                    <input type="text" x-model="fieldBlueprint.radio_max" class="input-generic">
                                </div>
                            </template>
                            {{-- <button @click="addField" class="btn btn-accent">Add input</button> --}}
                        </div>
                    </div>

                </div>

            </template>


            <template x-for="speaker in form.speakers">
                <div class="flex items-center justify-between">
                    <div class="input-generic-div w-full">
                        <label for="" class="text-lg font-bold text-accent" x-text="speaker.name"></label>

                        <template x-for="s_field in speaker.fields">

                            <div class="w-fill flex flex-col gap-2">
                                <div class="flex items-center justify-between">

                                    <div class="w-auto h-auto">
                                        <label for="" class="input-generic-label capitalize"
                                            x-text="s_field.question"></label>
                                        <template x-if="s_field.input_type !== 'radio'">
                                            <input :type="s_field.input_type" class="input-generic">
                                        </template>
                                        <template x-if="s_field.input_type === 'radio'">
                                            <div class="flex items-center gap-5">
                                                <template x-for="i in parseInt(s_field.radio_max)"
                                                    :key="i">
                                                    <div class="flex flex-col items-center">
                                                        <input type="radio" name="radio-4"
                                                            class="radio radio-accent" :value="i" />
                                                        <span x-text="i"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="btn btn-xs btn-primary"  @click="() => editFieldId = s_field.localId"><i class="fi fi-rr-edit"></i></button>
                                        <button class="btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="input-generic-div" x-show="editFieldId === s_field.localId">
                                    <div class="w-full flex items-center justify-between">
                                        <label for="" class="input-generic-label">Question</label>
                                        <button @click="() => editFieldId = null" class="btn btn-xs btn-error"><i
                                                class="fi fi-rr-cross"></i></button>
                                    </div>

                                    <input type="text" x-model="s_field.question" class="input-generic">
                                    <label for="" class="input-generic-label">Input Type</label>
                                    {{-- <select x-model="s_field.input_type" @change="checkInputTypeField($event)"
                                        class="select select-accent w-full">
                                        <option disabled selected>Select</option>
                                        <option value="text">Text</option> --}}
                                        {{-- <option value="number">Number</option> --}}
                                        {{-- <option value="radio">Radio</option> --}}
                                        {{-- <option>Light mode</option> --}}
                                    {{-- </select> --}}

                                    <template x-if="s_field.input_type === 'radio'">
                                        <div class="flex flex-col gap-2">
                                            <label for="" class="input-generic-label">Radio Range</label>
                                            <input type="number" x-model="s_field.radio_max" class="input-generic">
                                        </div>
                                    </template>
                                    {{-- <button @click="addField" class="btn btn-accent">Add input</button> --}}
                                </div>

                            </div>


                        </template>


                        {{-- <template x-if="field.input_type !== 'radio'">
                            <input :type="field.input_type" class="input-generic">
                        </template>

                        <template x-if="field.input_type === 'radio'">
                            <div class="flex items-center gap-5">
                                <template x-for="i in parseInt(field.radio_max)" :key="i">
                                    <div class="flex flex-col items-center">
                                        <input type="radio" name="radio-4" class="radio radio-accent"
                                            :value="i" />
                                        <span x-text="i"></span>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <div class="flex items-center justify-end gap-2">
                            <button class="btn btn-xs btn-primary"
                                @click="() => editFieldId = field.localId"><i class="fi fi-rr-edit"></i></button>
                            <button class="btn btn-xs btn-error" @click="removeField(field.localId)">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </div>

                        <div class="input-generic-div" x-show="editFieldId === field.localId">
                            <div class="w-full flex items-center justify-between">
                                <label for="" class="input-generic-label">Question</label>
                                <button @click="() => editFieldId = null" class="btn btn-xs btn-error"><i
                                        class="fi fi-rr-cross"></i></button>
                            </div>

                            <input type="text" x-model="field.question" class="input-generic">
                            <label for="" class="input-generic-label">Input Type</label>
                            <select x-model="field.input_type" @change="checkInputTypeField($event)"
                                class="select select-accent w-full">
                                <option disabled selected>Select</option>
                                <option value="text">Text</option>
                                <option value="number">Number</option>

                            </select>

                            <template x-if="field.input_type === 'radio'">
                                <div class="flex flex-col gap-2">
                                    <label for="" class="input-generic-label">Radio Range</label>
                                    <input type="text" x-model="fieldBlueprint.radio_max" class="input-generic">
                                </div>
                            </template>

                        </div> --}}
                    </div>

                </div>

            </template>






            <form method="POST" action="{{ route('events.evaluation.form.store') }}">
                @csrf

                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="evaluation_form" x-model="JSON.stringify(form)">

                <button class="btn btn-accent"> save </button>
            </form>

        </div>
    </div>
</x-dashboard.base>
