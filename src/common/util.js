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

    csvToTable (csv) {
        const rows = csv.replace(/"/g, '').split('\n');
        return rows.map(row => row.split(','));
    },

    arrayToTable (arr) {
        let res = arr.map(item => Object.values(item));
        res.unshift(Object.keys(arr[0]));
        return res;
    }

}