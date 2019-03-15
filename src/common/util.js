export default {

    csvToTable (csv) {
        const rows = csv.replace(/"/g, '').split('\n');
        return rows.map(row => row.split(','));
    },

    arrayToTable (arr) {
        let res = arr.map(item => Object.values(item));

        for (let i = 0; i < 100; i ++) {
            res.push([Math.random(), Math.random()])
        }

        res.unshift(Object.keys(arr[0]));
        return res;
    }

}