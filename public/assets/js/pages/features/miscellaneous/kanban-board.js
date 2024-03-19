"use strict";


        var kanban = new jKanban({
            element: '#kt_kanban_2',
            gutter: '0',
            widthBoard: '250px',
            boards: [{
                    'id': '_all_permissions',
                    'title': 'All Permissions',
                    'class': 'info',
                    'item': [{
                            'title': '<span class="font-weight-bold"> {{ $role->name }} </span>',
                            'class': 'light-primary',
                        },
                        {
                            'title': '<span class="font-weight-bold">Buy Milk</span>',
                            'class': 'light-primary',
                        }
                    ]
                }, {
                    'id': '_allowed_permissions',
                    'title': 'Allowed Permissions',
                    'class': 'success',
                    'item': [{
                            'title': '<span class="font-weight-bold">Do Something!</span>',
                            'class': 'light-success',
                        },
                        {
                            'title': '<span class="font-weight-bold">Run?</span>',
                            'class': 'light-success',
                        }
                    ]
                }
            ]
        });
