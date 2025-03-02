// Main pages
import Dashboard from '@/views/teacher/Dashboard.vue'
import Worksheets from '@/views/teacher/Worksheets.vue'
import Students from '@/views/teacher/Students.vue'

// Assignments page
import StudentsView from '@/views/teacher/students/View.vue'

// Worksheet pages
import WorksheetsCreate from "@/views/teacher/worksheets/Create.vue";
import WorksheetsView from "@/views/teacher/worksheets/View.vue";
import WorksheetsEdit from "@/views/teacher/worksheets/Edit.vue";

// Assignment page
import AssignmentsView from '@/views/common/assignments/View.vue'

const teacherRoutes = [
    {
        path: 'dashboard',
        name: 'TeacherDashboard',
        component: Dashboard,
        meta: {
            title: 'Dashboard',
        },
    },
    {
        path: 'worksheets',
        name: 'Worksheets',
        component: Worksheets,
        meta: {
            title: 'Worksheets',
        }
    },
    {
        path: 'worksheets/create',
        name: 'WorksheetsCreate',
        component: WorksheetsCreate,
        meta: {
            title: 'Create new worksheet',
        }
    },
    {
        path: 'worksheets/:id',
        name: 'WorksheetsView',
        component: WorksheetsView,
        meta: {
            title: 'View Worksheet',
        }
    },
    {
        path: 'worksheets/:id/edit',
        name: 'WorksheetsEdit',
        component: WorksheetsEdit,
        meta: {
            title: 'Edit Worksheet',
        }
    },
    {
        path: 'students',
        name: 'Students',
        component: Students,
        meta: {
            title: 'Students',
        }
    },
    {
        path: 'students/:id',
        name: 'StudentsView',
        component: StudentsView,
        meta: {
            title: 'Student',
        }
    },
    {
        path: 'assignments/:id',
        name: 'TeacherAssignmentsView',
        component: AssignmentsView,
        meta: {
            title: 'Worksheet',
        }
    },
]

export default teacherRoutes