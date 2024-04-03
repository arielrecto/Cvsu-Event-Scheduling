<x-dashboard.base>
    <div class="panel flex flex-col gap-2">
        <x-notification-message />
        <div class="flex items-center justify-between">
            <h1 class="panel-title">Faculty Members</h1>
            <a href="{{ route('instructors.create') }}" class="btn-generic">
                create
            </a>
        </div>

        {{-- <div class="w-full  flex items-center justify-end">
            <x-search :route="route('instructors.index')"/>
        </div>
 --}}


        <div class="overflow-y-auto">
            <table class="table">
                <!-- head -->
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        {{-- <th>Sections</th> --}}
                        <th>Date Added</th>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                   @forelse ($instructors as $instructor )
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $instructor->name }}</td>
                            <td>{{ $instructor->email }}</td>
                              <td>{{ date('F d, Y h:s A', strtotime($instructor->created_at)) }}</td>

                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{route('instructors.show', ['instructor' => $instructor->id])}}" class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    {{-- <a href="{{route('instructors.edit', ['instructor' => $instructor->id])}}" class="btn btn-xs btn-secondary">
                                        <i class="fi fi-rr-edit"></i>
                                    </a> --}}

                                    <form action="{{route('instructors.destroy', ['instructor' => $instructor->id])}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr class="bg-base-200">
                            <td>No Faculty Members</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
            {{ $instructors->links() }}
        </div>
    </div>
</x-dashboard.base>
