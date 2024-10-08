<template>
    <GuestLayout>
        <div class="flex flex-col justify-center items-center">
            <img :src="'/uploads/pamcham_logo2.jpg'"alt="" class="w-52">
            <h1 class="text-white text-center text-base!"> Ooops! You don't have enough voting credits left. </h1>
        </div>
    </GuestLayout>
    
</template>

<script> 
import GuestLayout from "../Layouts/GuestLayout.vue"


export default {
    components: {
        GuestLayout,
    },

    props: {
        candidates: Object,
        voter: Object
    },

}

</script>