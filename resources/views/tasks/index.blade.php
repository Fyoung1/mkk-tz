<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        #addTaskForm {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        #taskTitle {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #tasks {
            max-width: 600px;
            margin: 0 auto;
        }

        .task {
            background-color: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .task h3 {
            margin: 0 0 10px 0;
        }

        .subtask {
            margin-left: 20px;
            display: flex;
            align-items: center;
        }

        .subtask p {
            margin: 5px 0;
            flex-grow: 1;
        }

        .completed {
            text-decoration: line-through;
            color: #888;
        }

        .done-subtask-btn {
            background-color: transparent;
            border: 2px solid #ccc;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .done-subtask-btn .checkbox {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .fa-check {
            color: #28a745;
        }

        .fa-check.hidden {
            display: none;
        }

        .fa-check.visible {
            display: block;
        }

    </style>
</head>
<body>
<h1>To-Do List</h1>
<form id="addTaskForm">
    <input type="text" id="taskTitle" placeholder="Введите название задачи" required>
    <button type="submit">Добавить задачу</button>
</form>
<div id="tasks">
    @foreach($tasks as $task)
        <div class="task">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h4 class="{{ $task->status == \app\Enums\Status::Done ? 'completed' : '' }}">
                    {{ $task->title }}
                </h4>
                <button class="add-subtask-btn" onclick="addSubtask({{ $task->id }})">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div id="subtasks-{{ $task->id }}">
                @foreach($task->subtasks as $subtask)
                    <div class="subtask" style="display: flex; align-items: center;">
                        <button class="done-subtask-btn" onclick="doneSubtask({{ $subtask->id }})" style="margin-right: 10px;">
                            <div class="checkbox">
                                <i class="fas fa-check {{ $subtask->status == \app\Enums\Status::Done ? 'visible' : 'hidden' }}"></i>
                            </div>
                        </button>
                        <p class="{{ $subtask->status == \app\Enums\Status::Done ? 'completed' : '' }}">
                            {{ $subtask->title }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script>
    document.getElementById('addTaskForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const title = document.getElementById('taskTitle').value;
        fetch('/tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({title: title}),
        })
            .then(response => response.json())
            .then(data => {
                location.reload();
            });
    });

    function addSubtask(taskId) {
        const title = prompt('Введите название подзадачи:');
        if (title) {
            fetch(`/tasks/${taskId}/subtasks`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({title: title}),
            })
                .then(response => response.json())
                .then(data => {
                    location.reload();
                });
        }
    }

    function doneSubtask(subtaskId) {
        const button = event.target.closest('.done-subtask-btn');
        button.classList.toggle('completed');

        fetch(`/subtasks/${subtaskId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        })
            .then(response => response.json())
            .then(data => {
                location.reload();
            });
    }
</script>
</body>
</html>

