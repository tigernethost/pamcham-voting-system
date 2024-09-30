<template>
    <GuestLayout>
        <div >
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