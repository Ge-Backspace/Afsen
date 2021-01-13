
export const  menu = () => {
    return [
        {
            text: 'Home',
            icon: 'ni ni-shop text-primary',
            route: '/admin/beranda',
        },
        {
            text: 'Lapor',
            icon: 'el-icon-notebook-1 text-primary',
            route: '/admin/lapor'
        },
        {
            text: 'Kegiatan',
            icon: 'el-icon-baseball text-primary',
            route: '/admin/kegiatan'
        },
        {
            text: 'Berita',
            icon: 'el-icon-tickets text-primary',
            route: '/admin/berita'
        },
        {
            text: 'Informasi',
            icon: 'el-icon-warning-outline text-primary',
            route: '/admin/informasi'
        },
        {
            text: 'Users',
            icon: 'el-icon-user text-primary',
            route: '/admin/users'
        },
        {
            text: 'Master',
            icon: 'el-icon-folder text-primary',
            children: [
                {
                    text: "Pemda",
                    icon: 'el-icon-postcard',
                    route: '/admin/master/pemda'
                },
                // {
                //     text: "Setting",
                //     icon: 'el-icon-setting',
                //     route: '/admin/master/setting'
                // },
                // {
                //     text: "Bookstores",
                //     icon: 'el-icon-notebook-1',
                //     route: '/admin/master/bookstores'
                // },
                // {
                //     text: "Claim Category",
                //     icon: 'el-icon-tickets',
                //     route: '/admin/master/claim_category'
                // },
                // {
                //     text: "Skill",
                //     icon: 'el-icon-medal',
                //     route: '/admin/master/kemampuan'
                // },
            ]
        },
        // {
        //     text: 'Setting',
        //     icon: 'el-icon-setting text-primary',
        //     children: [
        //         {
        //             text: 'Point',
        //             icon: 'el-icon-coin',
        //             route: '/admin/settings/point'
        //         },
        //         {
        //             text: "User Admin",
        //             icon: 'el-icon-user',
        //             route: '/admin/master/admin'
        //         },
        //         {
        //             text: 'Agreement Claim Wallet',
        //             icon: 'el-icon-wallet',
        //             route: '/admin/settings/agreement-claim-wallet'
        //         },
        //         // {
        //         //     text: 'Rewards',
        //         //     icon: 'el-icon-trophy',
        //         //     route: '/admin/settings/rewards'
        //         // },
        //         // {
        //         //     text: 'Notification',
        //         //     icon: 'el-icon-bell',
        //         //     route: '/admin/settings/notification'
        //         // }
        //     ]
        // },
    ]
};
