<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <article class="card-body">
        <h4 class="card-title text-center mb-4 mt-1">相関図一覧</h4>
        <div>
          <b-card>
            <template #header>
              <b-tabs pills>
                <b-tab title="ユーザ名" active></b-tab>
                <b-tab title="作品名"></b-tab>
              </b-tabs>
            </template>

            <aside class="col-12" id="side_search">
              <b-form inline>
                <label class="mr-sm-2">検索</label>
                <b-form-input
                  class="mb-2 mr-sm-2 mb-sm-0"
                  placeholder="Search"
                ></b-form-input>
                <b-button variant="info">
                  <font-awesome-icon icon="search" />
                </b-button>
              </b-form>
            </aside>
          </b-card>
        </div>
        <hr />
        <br />
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>ユーザ名</th>
              <th>作品名</th>
              <th>閲覧</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, key) in times" :key="key">
              <td>{{ row.userName }}</td>
              <td>{{ row.workName }}</td>
              <td>
                <button type="button" class="btn btn-info">
                  <font-awesome-icon icon="eye" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </article>
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
  </div>
</template>

<script>
</script>

<style>
</style>
