const apiUrl = 'http://localhost/server/api.php';

function objToFormdata(obj) {
    let formData = new FormData();
    for ( let key in obj ) {formData.append(key, obj[key]);}
    return formData;
}

class Catalog {
    constructor() {
        this.container = document.querySelector('.catalog__products');
        this.count = 0;
        
        this.req = {
            api: 'get_catalog',
            category: 0,
            sort: 'default',
            limit: 6,
            page: 1
        }

        this.sortButtons = document.querySelectorAll('.sort__button');
        this.sortButtons.forEach((item) => {
            item.addEventListener('click', () => {
                this.sortButtons.forEach((item2) => {
                    item2.classList.remove('active');
                })
                item.classList.add('active');
                this.req.sort = item.getAttribute('sort');
                this.render();
            })
        })

        document.querySelector('#input-list-count').addEventListener('change', (e) => {
            this.req.limit = e.target.value;
            this.render();
        })

    }
    getRequest() {
        return objToFormdata(this.req);
    }
    async getData() {
        try {
            let response = await fetch(apiUrl, {method: 'POST', body: this.getRequest()});            
            let result = await response.json();
            if (result.success) {
                this.count = +result.count;
                return result.data
            } else {
                console.log(result);
            }
        } catch (error) {
            console.log(error);
        }
    }
    async render() {
        let data = await this.getData();
        this.container.innerHTML = '';
        data.forEach(element => {
            let div = document.createElement('div');
            div.className = "product";
            div.innerHTML = `
                <a href="/single.php?id=${element[0]}">
                    <div class="product__image"></div>
                    <div class="product__text">
                        <div class="product__name">${element[1]}</div>
                        <div class="product__price">${(+element[2]).toFixed(0)} руб.</div>
                    </div>
                </a>
            `
            this.container.append(div);
        });
        pagination.render();
    }
}

class Pagination {
    constructor() {
        this.container = document.querySelector('.pagination');
    }
    render() {
        this.container.innerHTML = ''; 
        
        this.page = catalog.req.page;
        this.limit = catalog.req.limit;
        this.count = catalog.count;
        this.pages = Number((this.count / this.limit).toFixed(0));
        
        this.container.innerHTML += `<div class="pag__prev disable"><<</div>`;

        for (let index = 1; index <= this.pages; index++) {
            let div = document.createElement('div');
            div.className = "pag__page";
            div.innerHTML = index;
            this.container.append(div);
        }

        this.container.innerHTML += `<div class="pag__next">>></div>`;
        this.container.querySelectorAll('.pag__page').forEach((item, index) => {
            if (index == catalog.req.page - 1) item.classList.add('active');
            item.addEventListener('click', () => {this.changePage(index)})
        })
    }
    changePage(page) {
        let buttons = this.container.querySelectorAll('.pag__page');
        buttons.forEach((item) => {item.classList.remove('active');})
        buttons[page].classList.add('active');
        catalog.req.page = page + 1;
        catalog.render();
    }
}


const catalog = new Catalog();
const pagination = new Pagination();
catalog.render();




export {
    
}