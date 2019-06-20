export default {

    chunk (array, limit) {
        let result = [];
        for (let i = 0; i < array.length / limit; i++) {
            result.push(array.slice(i * limit, i * limit + limit));
        }
        return result;
    },

    range (from, to) {
        let data = [];
        for (let i = from; i <= to; i++) {
            data.push(i);
        }
        return data;
    },

    jsonToTable (arr) {
        let headings = Object.keys(arr[0]);
        let results = arr.map(data => {
            return Object.values(data).map(value => {
                return value.toString();
            })
        });
        return [headings, ...results]
    }

}