<?php
$i = 0;
$municipios = ['Alambari', 'Aluminio', 'Americana', 'Aparecida', 'Aracariguama', 'Aracoiaba da Serra', 'Arapei', 'Areias', 'Artur Nogueira', 'Aruja', 'Bananal', 'Barueri', 'Bertioga', 'Biritiba-mirim', 'Boituva', 'Cacapava', 'Cachoeira Paulista', 'Caieiras', 'Cajamar', 'Campinas', 'Campos do Jordao', 'Canas', 'Capela do Alto', 'Caraguatatuba', 'Carapicuiba', 'Cerquilho', 'Cesario Lange', 'Cosmopolis', 'Cotia', 'Cruzeiro', 'Cubatao', 'Cunha', 'Diadema', 'Embu das Artes', 'Embu-guacu', 'Engenheiro Coelho', 'Ferraz de Vasconcelos', 'Francisco Morato', 'Franco da Rocha', 'Guararema', 'Guaratingueta', 'Guaruja', 'Guarulhos', 'Holambra', 'Hortolandia', 'Ibiuna', 'Igarata', 'Ilhabela', 'Indaiatuba', 'Ipero', 'Itanhaem', 'Itapecerica da Serra', 'Itapetininga', 'Itapevi', 'Itaquaquecetuba', 'Itatiba', 'Itu', 'Jacarei', 'Jaguariuna', 'Jambeiro', 'Jandira', 'Jumirim', 'Juquitiba', 'Lagoinha', 'Lavrinhas', 'Lorena', 'Mairinque', 'Mairipora', 'Maua', 'Mogi das Cruzes', 'Mongagua', 'Monte Mor', 'Monteiro Lobato', 'Morungaba', 'Natividade da Serra', 'Nova Odessa', 'Osasco', 'Paraibuna', 'Paulinia', 'Pedreira', 'Peruibe', 'Piedade', 'Pilar do Sul', 'Pindamonhangaba', 'Piquete', 'Pirapora do Bom Jesus', 'Poa', 'Porto Feliz', 'Potim', 'Praia Grande', 'Queluz', 'Redencao da Serra', 'Ribeirao Pires', 'Rio Grande da Serra', 'Roseira', 'Salesopolis', 'Salto', 'Salto de Pirapora', 'Santa Barbara do Oeste', 'Santa Branca', 'Santa Isabel', 'Santana de Parnaiba', 'Santo Andre', 'Santo Antonio de Posse', 'Santo Antonio do Pinhal', 'Santos', 'Sao Bento do Sapucai', 'Sao Bernardo do Campo', 'Sao Caetano do Sul', 'Sao Jose do Barreiro', 'Sao Jose dos Campos', 'Sao Lourenco da Serra', 'Sao Luiz do Paraitinga', 'Sao Miguel Arcanjo', 'Sao Paulo', 'Sao Roque', 'Sao Sebastiao', 'Sao Vicente', 'Sarapui', 'Silveiras', 'Sorocaba', 'Sumare', 'Suzano', 'Taboao da Serra', 'Tapirai', 'Tatui', 'Taubate', 'Tiete', 'Tremembe', 'Ubatuba', 'Valinhos', 'Vargem Grande Paulista', 'Vinhedo', 'Votorantim'];
echo 'de;para;numero;preco;linha;empresa;' . "\n";
foreach ($municipios as $de) {
    $para = json_decode(file_get_contents('http://www.emtu.sp.gov.br/emtu/home/home.asp?a=queroIrPara&cidadede=' . urlencode($de)), true);
    foreach ($para as $ate) {
        $url = 'http://www.emtu.sp.gov.br/Sistemas/linha/resultado.htm?cidadede=' . urlencode($de) . '&cidadeate=' . urlencode($ate['municipio']) . '&pag=origemdestino.htm';
        $get = file_get_contents($url);
        $get = str_replace("\t", '', $get);
        $get = str_replace("\n", '', $get);
        $get = str_replace("\r", '', $get);
        $get = preg_replace('/\s\s+/', ' ', $get);
        $matches = array();

        $preco = '/<td align=\"center\" class=\"texto\">(.*?)<\/td>/';
        $empresa = '/<td class=\"texto\">(.*?)<\/td>/';
        $linha = '/<span style=\"font\-size: 10px\">(.*?)<\/span>/';
        $numero = "/AbreJanelaAvaliacaoLinhas\(\'(.*?)\',\'\/sistemas\/linha/";
        $infoline = "/AbreJanelaAvaliacaoLinhas\(\'((.*?)+','(.*?))\'\)\"/";

        preg_match_all($preco, $get, $matches);
        $preco = $matches[1];
        preg_match_all($linha, $get, $matches);
        $linha = $matches[1];
        preg_match_all($numero, $get, $matches);
        $numero = array();

        foreach ($matches[1] as $key => $value) {
            if ($key % 2 == 0)
                continue;
            $numero[] = $value;
        }

        preg_match_all($empresa, $get, $matches);
        $empresa = array();

        foreach ($matches[1] as $key => $value) {
            $empresa[] = utf8_encode($value);
        }

        foreach ($linha as $key => $value) {
            $linha[$key] = str_replace('<br>', '', $linha[$key]);
            $linha[$key] = trim($linha[$key]);
        }

        preg_match_all($infoline, $get, $matches);
        $infoline = $matches[3];
        $uriline = array();        
        foreach ($infoline as $key => $value) {
            if ($key % 2 == 0)
                continue;
            $uriline[] = $value;
        }        

        foreach ($preco as $key => $value) {
            $url2 = 'http://www.emtu.sp.gov.br' . $uriline[$key];
            $get2 = utf8_encode(file_get_contents($url2));
            $matches = array();
            $servico = "/<tr><td class=\"destaque2\">Serviço:<\/td>((.*?)+<td colspan=\"2\"\>(.*?))<\/td><\/tr>/";
            preg_match_all($servico, $get2, $matches);
            $servico = array();
            $servico = trim($matches[3][0]);
            $servico = str_replace(' ', '', $servico);
            $servico = str_replace('(', ' (', $servico);
            var_dump($servico);

            //echo $de . ';' . $ate['municipio'] . ';' . $numero[$key] . ';' . $preco[$key] . ';' . $linha[$key] . ';' . $empresa[$key] . ";\n";
        }
        if(false)
            break (2);
        $i++;
    }
}
