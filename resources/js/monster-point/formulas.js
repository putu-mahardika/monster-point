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
        name: "SUM",
        expression: "SUM()",
        example: "SUM([1, 2, 3, 4, 5])",
    },
    {
        name: "AVG",
        expression: "AVG()",
        example: "AVG([1, 2, 3, 4, 5])",
    },
    {
        name: "SUBSTRACT",
        expression: "SUBSTRACT()",
        example: "SUBSTRACT([1, 2, 3, 4, 5])",
    },
    {
        name: "COUNT",
        expression: "COUNT()",
        example: "COUNT([1, 2, 3, 4, 5])",
    },
    {
        name: "MAX",
        expression: "MAX()",
        example: "MAX([1, 2, 3, 4, 5])",
    },
    {
        name: "MIN",
        expression: "MIN()",
        example: "MIN([1, 2, 3, 4, 5])",
    }
];
