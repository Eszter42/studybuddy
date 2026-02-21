<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>REST Client Demo</title>
</head>
<body style="font-family: Arial; padding: 40px;">

<h1>REST API kliens teszt</h1>

<hr>

<h2>Feladatok betöltése (GET)</h2>
<button onclick="loadTasks()">Betöltés</button>

<ul id="taskList"></ul>

<hr>

<h2>Új feladat létrehozása (POST)</h2>
<input type="text" id="newTitle" placeholder="Feladat címe">
<button onclick="createTask()">Létrehozás</button>

<script>

async function loadTasks() {
    const res = await fetch('/api/tasks', {
        headers: { 'Accept': 'application/json' }
    });

    const data = await res.json();
    const list = document.getElementById('taskList');
    list.innerHTML = '';

    data.data.forEach(task => {
        const li = document.createElement('li');

        li.innerHTML = `
            <strong>${task.title}</strong>
            (${task.status})
            <button onclick="toggleStatus(${task.id}, '${task.status}')">Státusz váltás</button>
            <button onclick="deleteTask(${task.id})">Törlés</button>
        `;

        list.appendChild(li);
    });
}

async function createTask() {
    const title = document.getElementById('newTitle').value;

    const res = await fetch('/api/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            title: title,
            priority: 'medium'
        })
    });

    document.getElementById('newTitle').value = '';
    loadTasks();
}

async function toggleStatus(id, currentStatus) {

    let newStatus = 'todo';
    if (currentStatus === 'todo') newStatus = 'doing';
    else if (currentStatus === 'doing') newStatus = 'done';

    await fetch(`/api/tasks/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            status: newStatus
        })
    });

    loadTasks();
}

async function deleteTask(id) {
    await fetch(`/api/tasks/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    loadTasks();
}

</script>

</body>
</html>