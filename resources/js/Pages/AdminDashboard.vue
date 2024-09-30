<template>
  <div>
    <h2 class="text-white"> Leaderboards </h2>
    <div class="col-12">
      <div class="card">
        <div class="table-responsive">
          <table class="table table-vcenter card-table">
            <thead>
              <tr>
                <th class="w-1">Rank</th>
                <th>Name</th>
                <th>Position in the BOD &/or Committee</th>
                <th>Votes</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(candidate, index) in leaderboard" :key="index">
                <td>
                  <div class="font-weight-large">{{ index + 1 }}</div>
                </td>
                <td>
                  <div class="d-flex py-1 align-items-center">

                    <img class="avatar me-3" :src="`/storage/${candidate.image}`" style="height: 60px; width: 60px;" alt="img">
                    <div class="flex-fill">
                      <div class="font-weight-medium">{{ candidate.name }}</div>
                      <div class="text-secondary"><a href="#" class="text-reset">{{ candidate.company }}</a></div>
                    </div>
                  </div>
                </td>
                <td>
                  <div>{{ candidate.position }}</div>
                </td>
                <td class="text-secondary"> {{ candidate.voters_count }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      candidates: { // Initialize with the data passed from the backend
        type: Array,
        required: true
      }
    },

    data() {
      return {
        leaderboard: [] // This will store the leaderboard data
      };
    },

    methods: {
      listenForVoteUpdates() {
        window.Echo.channel('candidates_leaderboard')
          .listen('.VoteSubmittedEvent', (e) => {
            console.log(this.leaderboard, e.topCandidates);
            this.leaderboard = e.topCandidates;
          });
      }
    },

    mounted() {
      this.leaderboard = this.candidates;

      this.listenForVoteUpdates();
    }
  };
</script>
