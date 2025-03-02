import Dashboard from '@/views/student/Dashboard.vue'
import AssignmentsIndex from '@/views/student/assignments/Index.vue'
import AssignmentsView from '@/views/common/assignments/View.vue'

const studentRoutes = [
    {
        path: 'dashboard',
        name: 'StudentDashboard',
        component: Dashboard,
        meta: {
            title: 'Dashboard',
        },
    },
    {
        path: 'assignments',
        name: 'StudentAssignments',
        component: AssignmentsIndex,
        meta: {
            title: 'Worksheets',
        }
    },
    {
        path: 'assignments/:id',
        name: 'StudentAssignmentsView',
        component: AssignmentsView,
        meta: {
            title: 'Worksheet',
        }
    },
]

export default studentRoutes