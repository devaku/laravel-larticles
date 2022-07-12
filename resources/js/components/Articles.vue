<template>
    <div>
        <h2>Articles</h2>
        <form @submit.prevent="addArticle" action="" class="mb-3">
            <div class="form-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Title"
                    v-model="article.title"
                />
            </div>
            <div class="form-group mb-3">
                <textarea
                    class="form-control"
                    name="body"
                    id=""
                    cols="30"
                    rows="1"
                    placeholder="Body"
                    v-model="article.body"
                ></textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-light">Save</button>
            </div>
        </form>
        <nav>
            <ul class="pagination">
                <li
                    :class="[{ disabled: !pagination.prev_page_url }]"
                    class="page-item"
                    @click="
                        pagination.prev_page_url &&
                            fetchArticles(pagination.prev_page_url)
                    "
                >
                    <a class="page-link" href="#">Previous</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#"
                        >Page {{ pagination.current_page }} of
                        {{ pagination.last_page }}</a
                    >
                </li>
                <li
                    :class="[{ disabled: !pagination.next_page_url }]"
                    class="page-item"
                    @click="
                        pagination.next_page_url &&
                            fetchArticles(pagination.next_page_url)
                    "
                >
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
        <div
            class="card card-body mb-2"
            v-for="article in articles"
            :key="article.id"
        >
            <h3>{{ article.title }}</h3>
            <p>{{ article.body }}</p>
            <hr />
            <button @click="editArticle(article)" class="btn btn-warning mb-2">
                Edit
            </button>
            <button @click="deleteArticle(article.id)" class="btn btn-danger">
                Delete
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            articles: [],
            article: {
                id: null,
                title: null,
                body: null,
            },
            article_id: "",
            pagination: {},
            edit: false,
        };
    },
    created() {
        this.fetchArticles();
    },

    mounted() {},

    methods: {
        async fetchArticles(page_url) {
            page_url = page_url || `${process.env.MIX_APP_URL}/api/articles`;
            let response = await fetch(page_url)
                .then((response) => response.json())
                .then((response) => response)
                .catch((e) => {
                    console.log(e);
                });

            let articles = response.data;
            await this.makePagination(response.meta, response.links);
            this.articles = articles;
        },

        async makePagination(meta, links) {
            this.pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
            };
        },

        deleteArticle(id) {
            if (confirm("Are you sure?")) {
                fetch(`${process.env.MIX_APP_URL}/api/articles/${id}`, {
                    method: "DELETE",
                })
                    .then((response) => response.json())
                    .then((response) => {
                        alert("Article removed!");
                        this.fetchArticles();
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }
        },

        addArticle() {
            // If editing
            if (this.edit) {
                fetch(`${process.env.MIX_APP_URL}/api/articles`, {
                    method: "PUT",
                    body: JSON.stringify(this.article),
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((response) => response.data)
                    .then((data) => {
                        // Clear form
                        this.article.title = ``;
                        this.article.body = ``;
                        alert("Article has been updated");
                        this.fetchArticles();
                    })
                    .catch((e) => {
                        console.log(e);
                    });

                this.edit = false;
            } else {
                fetch(`${process.env.MIX_APP_URL}/api/articles`, {
                    method: "POST",
                    body: JSON.stringify(this.article),
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((response) => response.data)
                    .then((data) => {
                        // Clear form
                        this.article.title = ``;
                        this.article.body = ``;
                        alert("Article has been added");
                        this.fetchArticles();
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }
        },

        editArticle(article) {
            this.edit = true;
            this.article.article_id = article.id;
            this.article.id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
        },
    },
};
</script>

<style></style>
