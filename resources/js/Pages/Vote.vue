<template>
    <VoterLayout>
        <div>
            <img :src="logo" alt="logo" class="w-full rounded-lg">
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