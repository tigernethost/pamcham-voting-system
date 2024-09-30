<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex items-center justify-center">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <button v-if="!user.voter && !requestSubmitted" @click="formRequestActivation" class="p-6 text-gray-900 dark:text-gray-100"> 
                        Request Account Activate {{ user.voter }} 
                    </button>

                    <img 
                    class="flex items-center justify-center max-h-full" 
                    :src="'/storage/' + user.voter.qr_code" 
                    v-else-if="user.voter && user.voter.is_activated && !requestSubmitted">


                    <button v-else-if="user.voter || requestSubmitted" disabled class="p-6 text-gray-900 dark:text-gray-100"> 
                        Waiting to activate by the admin 
                    </button>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

export default {
    components: {
        AuthenticatedLayout,
        Head,
    },

    props: {
        user: Object,
    },

    data() {
        return {
            requestSubmitted: false,
        };
    },
    methods: {
        formRequestActivation() {
            axios.post('voter/request-activation')
            .then(response => {
                console.log(response.data);
                this.requestSubmitted = true;
            })
            .catch(error => {
                console.log('There was an error processing request: ', error);
            });
        }
    },
};
</script>
