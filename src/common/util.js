export default {

    csvToArray (csv) {
        const rows = csv.replace(/"/g, '').split('\n');
        return rows.map(row => row.split(','));
    }

}