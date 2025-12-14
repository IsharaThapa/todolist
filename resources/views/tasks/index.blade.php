<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"
    >
</head>

<body class="bg-gray-100 min-h-screen flex justify-center pt-16">

<div class="w-full max-w-md bg-white rounded-lg shadow p-6">

    <!-- Title -->
    <h1 class="text-2xl font-semibold text-center mb-6">
        📝 To-Do List
    </h1>

    <!-- Success / Error Messages -->
    @if (session('success'))
        <div class="bg-green-100 text-green-700 text-sm p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 text-sm p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add Task -->
    <form method="POST" action="{{ route('task.store') }}" class="flex mb-5">
        @csrf

        <input
            type="text"
            name="description"
            placeholder="Add a new task..."
            class="flex-1 border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
            required
        >

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 rounded-r hover:bg-blue-700"
        >
            Add
        </button>
    </form>

    <!-- Task List -->
    <ul class="divide-y">

        @forelse ($tasks as $task)

            @php
                $status = strtolower(is_string($task['status'] ?? '') ? $task['status'] : 'pending');
            @endphp

            <li class="flex items-center justify-between py-3">

                <!-- Task Text -->
               
            <form method="POST" action="{{ route('task.update', $task['taskId']) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="description" value="{{ $task['description'] }}">
                        <input type="hidden" name="status" value="{{ $task['status']['S'] }}">
                        <button>
                            @if($task['status']['S'] == 'done')
                                <span class="line-through text-gray-500">{{ $task['description'] }}</span>
                            @else
                                <span>{{ $task['description'] }}</span>
                            @endif
                            
                        </button>
                    </form>
                <!-- Delete -->
                <form method="POST" action="{{ route('task.destroy', $task['taskId']) }}">
                    @csrf
                    @method('DELETE')

                    <button class="text-red-500 hover:text-red-700 text-sm">
                        Delete
                    </button>
                </form>

            </li>

        @empty
            <li class="text-center text-gray-500 py-6">
                No tasks yet 🚀
            </li>
        @endforelse

    </ul>

</div>

</body>
</html>
