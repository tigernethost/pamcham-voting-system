<template>
    <VoterLayout>
        <div>
            <img :src="logo" alt="logo" class="w-full rounded-lg">
        </div>
            
        <div class="flex flex-col gap-1">
            <p class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"> Scroll Down </p>
        </div>
    </VoterLayout>
    
    <VotingBallot
        :candidates="candidates"
        :voter="voter"
    />

    
</template>

<script> 
import VoterLayout from "../Layouts/VoterLayout.vue"
import GuestLayout from "../Layouts/GuestLayout.vue"
import VotingBallot from "./VotingBallot.vue"
import { Head } from '@inertiajs/vue3';


export default {
    components: {
        GuestLayout,
        VoterLayout,
        VotingBallot,
        Head,
    },

    props: {
        candidates: Object,
        voter: Object
    },


    data() {
        return {
            logo: '',
            
        }
    },


    mounted() {
        this.logo = '/uploads/pamcham_logo.jpg';
    },
}

</script>