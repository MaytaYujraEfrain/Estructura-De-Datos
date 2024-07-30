class MultiVPTree {
    constructor(points, numReferences = 2, leafSize = 10) {
        this.numReferences = numReferences;
        this.leafSize = leafSize;
        this.root = this.buildTree(points);
    }

    buildTree(points) {
        if (points.length <= this.leafSize) {
            return { points: points };
        }

        const references = [];
        for (let i = 0; i < this.numReferences; i++) {
            const index = Math.floor(Math.random() * points.length);
            references.push(points[index]);
        }

        const distances = points.map(point => references.map(ref => this.distance(point, ref)));

        const medianDistances = references.map((_, i) => this.median(distances.map(d => d[i])));
        const leftPoints = points.filter((_, idx) => distances[idx].every((d, i) => d <= medianDistances[i]));
        const rightPoints = points.filter((_, idx) => !leftPoints.includes(points[idx]));

        return {
            references: references,
            medianDistances: medianDistances,
            left: this.buildTree(leftPoints),
            right: this.buildTree(rightPoints)
        };
    }

    distance(a, b) {
        return a === b ? 0 : 1;
    }

    median(values) {
        values.sort((a, b) => a - b);
        const mid = Math.floor(values.length / 2);
        return values.length % 2 === 0 ? (values[mid - 1] + values[mid]) / 2 : values[mid];
    }

    search(query, k = 1) {
        return this._search(this.root, query, k);
    }

    _search(node, query, k) {
        if (node.points) {
            const distances = node.points.map(point => this.distance(query, point));
            return node.points.map((point, idx) => [point, distances[idx]]).sort((a, b) => a[1] - b[1]).slice(0, k);
        }

        const queryDistances = node.references.map(ref => this.distance(query, ref));

        const exploreLeft = queryDistances.every((d, i) => d <= node.medianDistances[i]);
        const bestBranch = exploreLeft ? node.left : node.right;
        const otherBranch = exploreLeft ? node.right : node.left;

        let bestResults = this._search(bestBranch, query, k);

        if (queryDistances.some((d, i) => d <= node.medianDistances[i] + Math.max(...bestResults.map(result => result[1])))) {
            const otherResults = this._search(otherBranch, query, k);
            bestResults = bestResults.concat(otherResults).sort((a, b) => a[1] - b[1]).slice(0, k);
        }
        return bestResults;
    }

    searchByImage(imageUrl, k = 1) {
        const imagePoints = this.extractImageFeatures(imageUrl);
        return this.search(imagePoints, k);
    }

    extractImageFeatures(imageUrl) {
        // Implementar la extracción de características de la imagen
        // Esto dependerá de la biblioteca o modelo de aprendizaje profundo que uses
        // Aquí solo devolvemos un ejemplo
        return [["image", imageUrl]];
    }
}

// Datos de ejemplo de puntos de características de imágenes categorizadas
const points = [
    ["paisaje", "https://concepto.de/wp-content/uploads/2015/03/paisaje-e1549600034372.jpg"],
    ["playa", "https://content.r9cdn.net/rimg/dimg/78/70/001b704a-city-15939-18738286522.jpg?width=1366&height=768&xhint=1483&yhint=964&crop=true"],
    ["calle", "https://st3.idealista.com/news/archivos/styles/fullwidth_xl/public/2022-03/calle_de_alcala_2_1.jpg?VersionId=j2l3VmrMQO22zcCf_KihPblcxRwCBk3S&itok=xJy1lNse"],
    ["paisaje", "https://concepto.de/wp-content/uploads/2015/03/paisaje-2-e1549600987975.jpg"],
    ["playa", "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/29/14/db/c6/caption.jpg?w=1200&h=-1&s=1"],
    ["calle", "https://ciudadesquecaminan.org/wp-content/uploads/2023/09/Callegrafia-foto.png"]
];

const tree = new MultiVPTree(points);
let currentPage = 1;
const resultsPerPage = 6;

function uploadImage() {
    const fileInput = document.getElementById('image-upload');
    const file = fileInput.files;
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imageUrl = e.target.result;
            searchImages(imageUrl);
        };
        reader.readAsDataURL(file[0]);
    }
}

function searchImages(imageUrl = null) {
    const queryInput = document.getElementById('query');
    const query = queryInput.value.trim();
    let results;
    if (imageUrl) {
        results = tree.searchByImage(imageUrl, 9);
    } else {
        results = tree.search(query, 9);
    }
    currentPage = 1;
    showPage(currentPage);
}

function showPage(page) {
    if (page < 1) return;
    currentPage = page;
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';
    const start = (currentPage - 1) * resultsPerPage;
    const end = start + resultsPerPage;
    const pageResults = tree.search(document.getElementById('query').value, 9).slice(start, end);
    pageResults.forEach(result => {
        const resultDiv = document.createElement('div');
        resultDiv.className = 'col-md-4 mb-4';
        resultDiv.innerHTML = `<div class="card">
                                <img src="${result[1]}" class="card-img-top" alt="${result[0]}">
                                <div class="card-body">
                                    <p class="card-text">${result[0]}</p>
                                </div>
                              </div>`;
        resultsDiv.appendChild(resultDiv);
    });
}