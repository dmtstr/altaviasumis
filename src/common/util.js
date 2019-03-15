export default {

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