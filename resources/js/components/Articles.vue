<template>
  <div>
    <form @submit.prevent="addArticle">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="article.title">
      </div>
      <div class="form-group">
        <input class="form-control" type="text" v-model="article.author" placeholder="Author">
      </div>
      <div class="form-group">
        <textarea class="form-control" v-model="article.body" placeholder="Body"></textarea>
      </div>
      <input type="submit" value="Submit" class="btn btn-success btn-block">
    </form>
    <hr>
    <h2>Articles</h2>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="[{disabled:!pagination.prev_page_url}]">
          <a class="page-link" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
        </li>
        <li class="page-item text-dark disabled">
          <a class="page-link">{{pagination.current_page}} of {{pagination.last_page}}</a>
        </li>
        <li class="page-item" :class="[{disabled:!pagination.next_page_url}]">
          <a class="page-link" @click="fetchArticles(pagination.next_page_url)">Next</a>
        </li>
      </ul>
    </nav>
    <div v-for="article in articles" v-bind:key="article.id">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">{{article.title}}</h3>
          <small>
            by
            <strong>{{article.author}}</strong>
          </small>
          <p class="card-text">{{article.body}}</p>
          <a class="btn btn-danger text-white" @click="deleteArticle(article.id)">Delete</a>
          <a class="btn btn-primary text-white" @click="editArticle(article)">Edit</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      articles: [],
      article: {
        id: "",
        title: "",
        body: "",
        author: ""
      },
      article_id: "",
      edit: false,
      pagination: {}
    };
  },
  created() {
    this.fetchArticles();
  },
  methods: {
    fetchArticles(page_url) {
      page_url = page_url || "/api/articles";
      let vm = this;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.articles = res.data;
          vm.makePagination(res.links, res.meta);
        })
        .catch(err => console.log(err));
    },
    makePagination(links, meta) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },
    deleteArticle(id) {
      if (confirm("Are You Sure?")) {
        fetch(`api/article/${id}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(res => {
            alert("Article Removed");
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      }
    },
    addArticle() {
      if (this.edit === false) {
        fetch("api/article", {
          method: "post",
          body: JSON.stringify(this.article),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            alert("Article Added");
            this.article.title = "";
            this.article.author = "";
            this.article.body = "";
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      } else {
        fetch("api/article", {
          method: "put",
          body: JSON.stringify(this.article),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            alert("Article Updated");
            this.article.title = "";
            this.article.author = "";
            this.article.body = "";
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      }
    },
    editArticle(article) {
      this.edit = true;
      this.article.id = article.id;
      this.article.title = article.title;
      this.article.body = article.body;
      this.article.author = article.author;
      this.article.article_id = article.id;
    }
  }
};
</script>

<style scoped>
</style>
