<template>
    <Head title="Pamcham" />
    
    <div class="flex flex-col py-5 px-4 sm:px-20 h-screen box-border overflow-hidden">
        <header>
            <img :src="'uploads/pamcham_logo2.jpg'" alt="" class="w-24 sm:w-32">
        </header>
        
        <div class="flex flex-col sm:flex-row justify-center items-center flex-grow h-full overflow-hidden">
            <div class="basis-full sm:basis-1/3 text-center sm:text-left">
                <h1 class="text-lg sm:text-xl pb-2 font-bold">Pamcham E-Voting System </h1>
                <small class="text-xs">The E-Voting System is a secure, user-friendly platform designed to streamline the voting process. It enables participants to cast their votes electronically, ensuring accuracy, transparency, and efficiency. With its real-time monitoring, automated tallying, and data security features, the system eliminates manual errors and simplifies election management for organizations of all sizes.</small>
            </div>
            
            <div class="basis-full sm:basis-2/3 h-48 sm:h-[calc(100%-2rem)] max-h-full overflow-hidden mt-4 sm:mt-0">
                <img :src="'uploads/vector.jpg'" alt="" class="h-full w-full object-cover">
            </div>
        </div>
    </div>
</template>

<script>
</script>
