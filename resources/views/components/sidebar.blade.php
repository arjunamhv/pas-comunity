<div class="flex flex-col w-16 bg-gray-800 text-white min-h-screen transition-all duration-300" id="sidebar">
    <div class="flex items-center justify-start p-3" id="toggleContainer">
        <button id="toggleSidebar" class="text-white p-3 rounded-full hover:bg-gray-700">
            <i id="toggleIcon" class="fas fa-bars transition-transform duration-300"></i>
        </button>
    </div>

    <ul class="flex-1 mt-6 space-y-2" id="menuList">
        <!-- Section Title: Dashboard -->
        <li>
            <span class="text-gray-400 text-sm uppercase ml-4 collapseIcon hide-item">Main Menu</span>
        </li>
        <li>
            <a href="{{ route('dashboard') }}" class="flex items-center p-3 mx-3 rounded-full hover:bg-gray-700">
                <i class="fa-solid fa-gauge"></i>
                <span class="ml-2 text-sm md:inline collapseIcon hide-item">Dashboard</span>
            </a>
        </li>
        <!-- Section Title: User Settings -->
        <li>
            <span class="text-gray-400 text-sm uppercase ml-4 collapseIcon hide-item">User Settings</span>
        </li>
        <li>
            <a href="#" class="flex items-center p-3 mx-3 rounded-full hover:bg-gray-700">
                <i class="fa-solid fa-user"></i>
                <span class="ml-2 text-sm md:inline collapseIcon hide-item">User Index</span>
            </a>
        </li>
        <li>
            <a href="#" class="flex items-center p-3 mx-3 rounded-full hover:bg-gray-700">
                <i class="fa-solid fa-user-plus"></i>
                <span class="ml-2 text-sm md:inline collapseIcon hide-item">Add User</span>
            </a>
        </li>
        <!-- Section Title: News Control -->
        <li>
            <span class="text-gray-400 text-sm uppercase ml-4 collapseIcon hide-item">News Control</span>
        </li>
        <li>
            <a href="{{ url('/control/news') }}" class="flex items-center p-3 mx-3 rounded-full hover:bg-gray-700">
                <i class="fa-solid fa-newspaper"></i>
                <span class="ml-2 text-sm md:inline collapseIcon hide-item">News Index</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/control/news/create') }}" class="flex items-center p-3 mx-3 rounded-full hover:bg-gray-700">
                <i class="fa-solid fa-circle-plus"></i>
                <span class="ml-2 text-sm md:inline collapseIcon hide-item">Add News</span>
            </a>
        </li>
        <!-- Section Title: Events Control -->
        <li>
            <span class="text-gray-400 text-sm uppercase ml-4 collapseIcon hide-item">Events Control</span>
        </li>
        <li>
            <a href="{{ url('/control/events') }}" class="flex items-center p-3 mx-3 rounded-full hover:bg-gray-700">
                <i class="fa-solid fa-calendar"></i> <span class="ml-2 text-sm md:inline collapseIcon hide-item">Events
                    Index</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/control/events/create') }}" class="flex items-center p-3 mx-3 rounded-full hover:bg-gray-700">
                <i class="fa-solid fa-calendar-plus"></i> <span class="ml-2 text-sm md:inline collapseIcon hide-item">Add
                    Events</span>
            </a>
        </li>
    </ul>
</div>

<script>
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    const collapseIcons = document.querySelectorAll('.collapseIcon'); // corrected variable name

    toggleButton.addEventListener('click', () => {
        // Toggle sidebar width
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-16');

        // Change icon rotation based on sidebar state
        if (sidebar.classList.contains('w-64')) {
            toggleIcon.classList.remove('rotate-0');
            toggleIcon.classList.add('rotate-90');

            // Show elements when expanded
            collapseIcons.forEach(icon => {
                icon.classList.remove('hide-item');
            });
        } else {
            toggleIcon.classList.remove('rotate-90');
            toggleIcon.classList.add('rotate-0');

            // Hide elements when collapsed
            collapseIcons.forEach(icon => {
                icon.classList.add('hide-item');
            });
        }
    });
</script>

<style>
    .rotate-0 {
        transform: rotate(0deg);
    }

    .rotate-90 {
        transform: rotate(90deg);
    }

    .hide-item {
        display: none;
    }
</style>
