<style>

table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
</style>

<table>
    <thead>
				<tr>
                    <th>Id</th>
					<th>Noms</th>
					<th>Cognom</th>
					<th>Nota M01 (Sistemes Operatius)</th>
                    <th>Nota M02 (Bases de Dades)</th>
                    <th>Nota M03 (Programació)</th>
                    <th>Nota M04 (Llenguatge de marques i XML)</th>
                    <th>Nota M011 (FOL)</th>
                    <th>Nota M012 (EIE)</th>
				</tr>
			</thead>
    <tbody>
    <?php
        require("biblioteca.php");
        $llista = fLlegeixFitxer(FITXER_ALUMNES);
        fCreaTaula($llista,"alumnes");
    ?>
    </tbody>
</table>