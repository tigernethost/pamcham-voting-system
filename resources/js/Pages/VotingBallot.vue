<template>
    <!-- Alerts -->
    <div v-if="showAlert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative z-50" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 600px;">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">You don't have enough voting credits left!</span>
        <span class="absolute top-0 right-0 px-4 py-3 z-30" @click="showAlert = false">
          <svg
            class="fill-current h-6 w-6 text-red-500"
            role="button"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          >
            <title>Close</title>
            <path
              d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"
            />
          </svg>
        </span>
    </div>

    <div class="min-h-screen bg-gray-100">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
      </div>
      <div class="bg-white p-6 rounded-lg shadow-lg mx-4 mt-6 mb-10">
        <h2 class="text-center text-xl font-bold mb-4">Pamcham Director</h2>
        <div class="mb-6 text-center">  
          <div class="text-lg grid gap-10 grid-cols-1 md:grid-cols-3">
            <div v-for="(candidate, index) in candidates" :key="index" class="flex flex-col items-center justify-center bg-blue-100 border-t border-b text-blue-700 px-4 py-3 rounded-lg gap-5 relative">
              <small class="text-white bg-gray-800 p-2 w-8 h-8 flex items-center justify-center rounded-full absolute -left-3 -top-3">
                {{ index + 1 }}
              </small>

              <div class="relative flex items-center bg-gray-100 rounded-lg w-full px-4 py-2 gap-2 flex-wrap">
                <p v-if="votedCandidates.includes(candidate) || checkIfVoted(candidate)" 
                  class="absolute inset-0 flex justify-center items-center text-red-400 backdrop-blur-sm hover:backdrop-blur-lg bg-white/20 font-medium text-xl z-10"> 
                  Voted {{ candidate.name }}
                </p>

                <img :src="`/storage/${candidate.image}`" alt="George Walker" class="h-12 w-12 min-w-[48px] rounded-full border-2 border-gray-200 z-0">

                <div class="text-gray-800 flex-1 text-start z-0">{{ candidate.name }} - <small class="text-sm">{{ candidate.company }}</small></div>


                <span class="cursor-pointer z-0" @click="preview(candidate)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 min-w-[24px]">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                </span>
              </div>
              <div class="flex space-x-4">
                <button v-if="!votedCandidates.includes(candidate) && !checkIfVoted(candidate)" @click="addVote(candidate)" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                  Vote
                </button>

                <button v-else-if="votedCandidates.includes(candidate) && !checkIfVoted(candidate)" @click="undoVote(candidate)" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                  Undo
                </button> 
              </div>

            </div>
          </div>
        </div>
      </div>
  
      <!-- Menu Nav -->
      <div v-if="showMenu" class="z-10 backdrop-blur-sm hover:backdrop-blur-lg bg-white/25  rounded-lg shadow-lg py-4 px-10 flex justify-between items-center fixed bottom-0 w-full mb-4">
        <small> Voting Credits Left: {{ this.voter.voting_credits - votedCandidates.length }}</small>
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd" d="M13.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L11.69 12 4.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
            <path fill-rule="evenodd" d="M19.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06L17.69 12l-6.97-6.97a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
          </svg>
          <h2 class="text-xl font-bold cursor-pointer" @click="submitPreview">Submit</h2>
        </div>
      </div>
    </div>

    <!-- Candidate Preview -->
    <div v-if="previewCandidate.modalOn" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
      <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full sm:w-11/12 md:w-2/3 lg:w-1/2">
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <img :src="`/storage/${previewCandidate.image}`" alt="George Walker" class="h-12 w-12 min-w-[48px] rounded-full border-2 border-gray-200 z-0">
              </div>
              <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">{{ previewCandidate.name }} <span> <small class="text-sm text-gray-500"><br> {{ previewCandidate.company }} </small></span> </h3>
                <div class="mt-2">
                  
                  <p class="text-xs text-gray-500">{{ previewCandidate.position }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="previewCandidate.modalOn = false">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Voted Candidates Preview -->
    <div v-if="submitModal" class="fixed inset-0 z-10 flex items-center justify-center">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="submitModal = false"></div>

      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full sm:w-11/12 md:w-2/3 lg:w-1/2 max-h-full overflow-y-auto mx-4">
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
          <!-- Header -->
          <div class="flex justify-end items-center mb-6">
            <button @click="submitModal = false" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
              Close
            </button>
          </div>

          <!-- Summary List -->
          <div class="bg-gray-50 p-6 rounded-lg shadow-inner mb-6">
            <h3 class="text-lg font-semibold mb-4"> {{ votedCandidates.length > 0 ? 'Here is a summary of your voted candidates:' : 'No voted candidates' }}</h3>
            <ul class="space-y-4">
              <li v-for="(candidate, index) in votedCandidates" :key="index" class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-start">
                  <!-- Candidate Number -->
                  <div class="flex-shrink-0 bg-blue-500 text-white h-8 w-8 flex items-center justify-center rounded-full font-bold">
                    {{ index + 1 }}
                  </div>
                  
                  <!-- Candidate Details -->
                  <div class="ml-4">
                    <h4 class="text-xl font-semibold text-gray-800">{{ candidate.name }}</h4>
                    <p class="text-sm text-gray-600 mb-2">Company: {{ candidate.company }}</p>

                    <p class="text-xs text-gray-500">Position in the BOD &/or Committee: {{ candidate.position }}</p>
                    <p class="text-xs text-gray-500">Candidate Number: {{ getCandidateIndex(candidate) }}</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>

          <!-- Footer with Submit Button -->
          <div class="px-4 py-4 sm:px-6 flex justify-center items-center bg-gray-100 border-t" v-if="votedCandidates.length > 0">
            <button @click="submitVotes" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg text-lg font-semibold">
              Submit Votes
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="isLoading" class="fixed inset-0 bg-gray-500 bg-opacity-50 z-50 flex justify-center items-center">
      <svg
        class="animate-spin h-16 w-16 text-blue-500"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.964 7.964 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
    </div>

</template>

<script>
import axios from 'axios';


  export default {
    data() {
      return {
        showMenu: false,
        
        submittedCandidates: this.voter.candidates,
        votedCandidates: [],
        isVoted: false,
        isLoading: false,

        submitModal: false,

        previewCandidate: {
          modalOn: false,
          name: '',
          position: '',
          image: '',
        },
        
        showAlert: false,

      };
    },

    props: { 
        candidates: Object,
        voter: Object
    },

    methods: {
      handleScroll() {
        this.showMenu = window.scrollY > 100;
      },

      addVote (candidate) {
        if(this.votingCreditsLeft > 0 && !this.votedCandidates.includes(candidate)) {
          this.votedCandidates.push(candidate);
        } else if(this.votingCreditsLeft.length === 0) {
          alert('No voting credits left');
        } else{
          this.showAlert = true;
          setTimeout(() => {
            this.showAlert = false;
          }, 5000);
        }

        console.log(this.showAlert)
      },

      undoVote(candidate) {
        //this.votedCandidates.remove(candidate);

        this.votedCandidates = this.votedCandidates.filter(cand => {
          return cand.id !== candidate.id;
        })

        console.log(this.votedCandidates)
      },

      preview (candidate) {
        this.previewCandidate.modalOn = true;
        this.previewCandidate.name = candidate.name;
        this.previewCandidate.company = candidate.company
        this.previewCandidate.position = candidate.position;
        this.previewCandidate.image = candidate.image
      },

      submitPreview() {
        this.submitModal = true;
      },

      submitVotes() {
        this.isLoading = true;
        if(this.votedCandidates.length > 0) {
          axios.post(`/pamcham/${this.voter.uuid}/voting-ballot/submit`, {
            candidates: this.votedCandidates,
            voting_credits: this.votingCreditsLeft,
          }).then(response => {
            console.log(response);
            this.isLoading = false;
            this.submitModal = false;
            window.location.href = `/vote-success/${this.voter.uuid}`;
          }).catch(err => {
            console.log(err);
            this.isLoading = false;
          })

        }
        
      
      },

      checkIfVoted(candidate) {
        return this.submittedCandidates.some(submittedCandidate => {
          return submittedCandidate.id === candidate.id;
        });
      },

      getCandidateIndex(candidate) {
        return this.candidates.findIndex(c => c.id === candidate.id) + 1;
      }

      
    },

    computed: {
      votingCreditsLeft () {
        return this.voter.voting_credits - this.votedCandidates.length
      }
    },


    mounted() {
      window.addEventListener("scroll", this.handleScroll);
    },


    beforeDestroy() {
      window.removeEventListener("scroll", this.handleScroll);
    },

  };
</script>