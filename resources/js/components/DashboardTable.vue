<template>
  <v-container>
    <v-row>
      <!-- Upload buttons -->
      <!-- <v-btn @click="openFileInput" color="primary"  variant="outlined" class="mx-4">Upload Files</v-btn> -->
      <v-file-input
        label="Upload Excel Sheet"
        class="mr-4"
        variant="outlined"
      ></v-file-input>

      <v-btn color="info" class="mr-4 mt-2"
        >Remove Duplicates and Download</v-btn
      >
      <v-btn color="info" class="mt-2">Save Data</v-btn>
    </v-row>

    <!--fiters -->
    <v-row class="my-4">
      <v-col>
        <v-text-field
          v-model="email"
          label="Search by Email"
          variant="outlined"
          @keydown.enter="fetchData"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          v-model="date"
          label="Search by Date"
          variant="outlined"
          @click="openDatePickerModal"
          append-icon="mdi-calendar"
        >
          <v-dialog v-model="datePickerModal" width="290px">
            <v-date-picker v-model="date" scrollable>
              <div class="flex-grow-1 bottom:0"></div>
              <v-btn
                text
                color="primary"
                class="bottom"
                @click="closeDatePickerModal"
                >Cancel</v-btn
              >
              <v-btn text color="primary" class="ml-4 bottom" @click="saveDate"
                >OK</v-btn
              >
            </v-date-picker>
          </v-dialog>
        </v-text-field>
      </v-col>
      <v-col>
        <v-autocomplete
          v-model="uploader"
          label="Search by Uploader"
          variant="outlined"
          :items="['vaibhav', 'harsh']"
          clearable
          @keydown.enter="fetchData"
        ></v-autocomplete>
      </v-col>
      <v-col></v-col>
      <v-col>
        <v-btn @click="searchAll" color="primary" class="mt-2 ml-16"
          >Search</v-btn
        >
      </v-col>
      <v-col>
        <v-btn @click="clearSearch" color="primary" class="mt-2">
          Clear Search</v-btn
        >
      </v-col>
    </v-row>

    <!-- Data table -->
    <v-data-table-server
      v-model:items-per-page="itemsPerPage"
      :headers="headers"
      :items-length="serverItems.length"
      :items="serverItems"
      :loading="loading"
      :items-per-page-options="[5, 10, 15, 20, -1]"
    ></v-data-table-server>
  </v-container>
</template>
  
  <script>
export default {
  data() {
    return {
      date: null,
      email: "",
      uploader: "",
      datePickerModal: false,
      loading: false,
      serverItems: [
        {
          index: 1,
          first_name: "vaibhav",
          last_name: "Mishra",
          email: "user1@example.com",
          uploader: "vaibhav",
          uploaded_on: "2023-01-01",
        },
        {
          index: 2,
          first_name: "harsh",
          last_name: "singh",
          email: "harsh@example.com",
          uploader: "harsh",
          uploaded_on: "2023-01-02",
        },
      ],
      itemsPerPage: 5,
      currentPage: 1,
      headers: [
        { title: "S.No", key: "index", sortable: true },
        { title: "First Name", key: "first_name", sortable: true },
        { title: "Last Name", key: "last_name", sortable: true },
        { title: "Email", key: "email", sortable: true },
        { title: "Uploader", key: "uploader", sortable: true },
        { title: "Uploaded On", key: "uploaded_on", sortable: true },
      ],
    };
  },

  methods: {
    fetchData() {
      const filteredData = this.serverItems.filter((item) =>
        this.matchesSearchCriteria(item)
      );
      this.serverItems = filteredData;
      this.totalItems = filteredData.length;
    },

    matchesSearchCriteria(item) {
      const emailMatch = item.email.includes(this.email);
      const dateMatch = this.date ? item.uploaded_on === this.date : true;
      const uploaderMatch = item.uploader.includes(this.uploader);

      return emailMatch && dateMatch && uploaderMatch;
    },
    openDatePickerModal() {
      this.datePickerModal = true;
    },

    closeDatePickerModal() {
      this.datePickerModal = false;
    },

    saveDate() {
      this.closeDatePickerModal();
    },

    searchAll() {
      this.fetchData();
    },

    clearSearch() {
      console.log("serav");
      this.email = "";
      this.date = "";
      this.uploader = "";
      this.fetchData();
    },
  },
};
</script>
  