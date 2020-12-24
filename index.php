<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check DHT sensor log</title>
    <link rel="stylesheet" href="./css/bulma.min.css">
</head>

<body>
    <nav class="navbar is-warning" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="https://parzibyte.me/l/fW8zGd">
                <img alt="" src="parzibyte.png" style="max-height: 80px;" />
            </a>
            <button class="navbar-burger is-warning button" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>
        </div>
        <div class="navbar-menu">
            <div class="navbar-start">
                <a href="index.php" class="navbar-item">
                    Chart
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a target="_blank" rel="noreferrer" href="https://parzibyte.me/l/fW8zGd" class="button is-primary">
                            <strong>Support & Help</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="app" class="section">
        <div class="columns">
            <div class="column is-one-third">
                <p>Start</p>
                <div class="field has-addons">
                    <div class="control">
                        <input @change="onDateOrTimeChanged" v-model="startDate" class="input" type="date">
                    </div>
                    <div class="control ml-2">
                        <input @change="onDateOrTimeChanged" v-model="startTime" class="input" type="time">
                    </div>
                </div>
            </div>
            <div class="column is-one-third">
                <p>End</p>
                <div class="field has-addons">
                    <div class="control">
                        <input @change="onDateOrTimeChanged" v-model="endDate" class="input" type="date">
                    </div>
                    <div class="control ml-2">
                        <input @change="onDateOrTimeChanged" v-model="endTime" class="input" type="time">
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <canvas id="chart"></canvas>
        </div>
    </div>
    <script src="./js/Chart.bundle.min.js"></script>
    <script src="./js/vue.min.js"></script>
    <script src="./js/script.js"></script>
</body>


</html>