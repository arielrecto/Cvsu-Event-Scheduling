<x-dashboard.base>
    <div class="panel">
        <x-notification-message />
        <div class="flex items-center justify-between">
            <h1 class="panel-title">Announcements</h1>
            <a href="{{ route('announcements.create') }}" class="btn-generic">
                Create Announcement
            </a>
        </div>
        <div class="overflow-y-auto">
            <table class="table">
                <!-- head -->
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Posted At</th>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($announcements as $announcement)
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $announcement->title }}</td>
                            <td>{{date('F d, Y', strtotime($announcement->created_at))}}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('announcements.show', ['announcement' => $announcement->id]) }}"
                                        class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{ route('announcements.edit', ['announcement' => $announcement->id]) }}"
                                        class="btn btn-xs btn-secondary">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <form action="{{route('announcements.destroy', ['announcement' => $announcement->id])}}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button  class="btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr class="bg-base-200">
                            <td>No Announcements</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>





            {{ $announcements->links() }}
        </div>
    </div>
</x-dashboard.base>
