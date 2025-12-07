<!DOCTYPE html>
<html>
<head>
    <title>To-Do App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">To-Do List</h1>

        <!-- Add Task -->
        <form method="POST" action="{{ route('task.store') }}" class="flex mb-4">
            @csrf
            <input type="text" name="title" class="border p-2 flex-grow" placeholder="New task...">
            <button type="submit" class="bg-blue-600 text-white px-4 ml-2">Add</button>
        </form>

        <!-- Task List -->
        <ul>
            @foreach($tasks as $task)
                <li class="flex justify-between items-center py-2 border-b">
                    <form method="POST" action="{{ route('task.update', $task->id) }}">
                        @csrf
                        @method('PATCH')
                        <button>
                            @if($task->is_done)
                                <span class="line-through text-gray-500">{{ $task->title }}</span>
                            @else
                                <span>{{ $task->title }}</span>
                            @endif
                        </button>
                    </form>

                    <form method="POST" action="{{ route('task.delete', $task->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
