
export const  menu = () => {
    return [
        {
            text: 'Dashboard',
            icon: 'ni ni-shop text-primary',
            route: '/admin/beranda',
        },
        {
            text: 'Employees',
            icon: 'el-icon-notebook-1 text-primary',
            route: '/admin/employees'
        },
        {
            text: 'Time Management',
            icon: 'el-icon-baseball text-primary',
            // route: '/admin/kegiatan',
            children: [
                {
                    text: "Time Off",
                    icon: 'el-icon-postcard',
                    route: '/admin/time_management/timeoff'
                },
                {
                    text: "Attendance",
                    icon: 'el-icon-postcard',
                    route: '/admin/time_management/attendance'
                },
                {
                    text: "Schedule",
                    icon: 'el-icon-postcard',
                    route: '/admin/time_management/schedule'
                },
                {
                    text: "Calendar",
                    icon: 'el-icon-postcard',
                    route: '/admin/time_management/calendar'
                },
                {
                    text: "Timesheet",
                    icon: 'el-icon-postcard',
                    route: '/admin/time_management/timesheet'
                },
                
            ]
        },
        {
            text: 'Finances',
            icon: 'el-icon-tickets text-primary',
            // route: '/admin/berita',
            children: [
                {
                    text: "Reimbursement",
                    icon: 'el-icon-postcard',
                    route: '/admin/finances/reimbursement'
                },
                {
                    text: "Cash Advance Request",
                    icon: 'el-icon-postcard',
                    route: '/admin/finances/cash'
                },
            ]
        },
        {
            text: 'Company',
            icon: 'el-icon-warning-outline text-primary',
            route: '/admin/company'
        },
        {
            text: 'Notifikasi',
            icon: 'el-icon-notebook-1 text-primary',
            route: '/admin/notifikasi'
        },
        // {
        //     text: 'Calendar',
        //     icon: 'el-icon-user text-primary',
        //     route: '/admin/users'
        // },
        
    ]
};
