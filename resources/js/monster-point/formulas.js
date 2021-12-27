window.getFormulaColumn = (columnName, textTransform = '') => {
    return formulas.map((formula) => {
        switch (textTransform) {
            case 'lower':
                    return formula[columnName].toLowerCase();
                break;

            case 'upper':
                    return formula[columnName].toUpperCase();
                break;

            default:
                    return formula[columnName];
                break;
        }
    });
}

window.formulas = [
    {
        name: "@value",
        expression: "@value",
        example: `-- Digunakan untuk memanggil value yang di hasilkan oleh user/member \n @value / 30`,
    },
    {
        name: "Case",
        expression: `case\n\twhen condition\n\tthen\n\t\tstatement\n\telse\n\t\tstatement\nend`,
        example: `-- Digunakan untuk menerapkan kondisi dalam formula \nCASE\n\tWHEN (@value/30 ) > 1000\n\tTHEN\n\t\t1000\n\tELSE\n\t\t200\nEND`,
    },
    {
        name: "Get Date",
        expression: `getdate()`,
        example: `-- Digunakan untuk mendapatkan tanggal dan jam saat ini \ngetdate()`
    },
];
