<template>
    <GuestLayout>
        <div class="flex flex-col justify-center items-center">
            <img :src="'/uploads/pamcham_logo2.jpg'"alt="" class="w-52">
            <h1 class="text-white text-center text-base!"> Vote Submitted Successfully! </h1>
            <p class="text-white text-center text-xs" v-if="votingCredits > 0">You still have <span class="font-bold"> {{ votingCredits }} </span> voting credits. Scan your QR again to cast your remaining votes </p>
        </div>
    </GuestLayout>

</template>


<script>

import GuestLayout from "../Layouts/GuestLayout.vue";
export default {    
    components: {
        GuestLayout
    },

    data() {
        return {
            votingCredits: this.voter.voting_credits,
        }
    },

    props: {
        voter: Object,
    }
}
</script>