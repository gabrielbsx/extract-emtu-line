from bs4 import BeautifulSoup
import urllib.parse, requests, json

municipios = {
    'Alambari', 'Aluminio', 'Americana', 'Aparecida', 'Aracariguama', 'Aracoiaba da Serra', 'Arapei', 'Areias', 'Artur Nogueira',
    'Aruja', 'Bananal', 'Barueri', 'Bertioga', 'Biritiba-mirim', 'Boituva', 'Cacapava', 'Cachoeira Paulista', 'Caieiras', 'Cajamar', 'Campinas',
    'Campos do Jordao', 'Canas', 'Capela do Alto', 'Caraguatatuba', 'Carapicuiba', 'Cerquilho', 'Cesario Lange', 'Cosmopolis', 'Cotia', 'Cruzeiro',
    'Cubatao', 'Cunha', 'Diadema', 'Embu das Artes', 'Embu-guacu', 'Engenheiro Coelho', 'Ferraz de Vasconcelos', 'Francisco Morato', 'Franco da Rocha',
    'Guararema', 'Guaratingueta', 'Guaruja', 'Guarulhos', 'Holambra', 'Hortolandia', 'Ibiuna', 'Igarata', 'Ilhabela', 'Indaiatuba', 'Ipero', 'Itanhaem',
    'Itapecerica da Serra', 'Itapetininga', 'Itapevi', 'Itaquaquecetuba', 'Itatiba', 'Itu', 'Jacarei', 'Jaguariuna', 'Jambeiro', 'Jandira', 'Jumirim',
    'Juquitiba', 'Lagoinha', 'Lavrinhas', 'Lorena', 'Mairinque', 'Mairipora', 'Maua', 'Mogi das Cruzes', 'Mongagua', 'Monte Mor', 'Monteiro Lobato',
    'Morungaba', 'Natividade da Serra', 'Nova Odessa', 'Osasco', 'Paraibuna', 'Paulinia', 'Pedreira', 'Peruibe', 'Piedade', 'Pilar do Sul', 'Pindamonhangaba',
    'Piquete', 'Pirapora do Bom Jesus', 'Poa', 'Porto Feliz', 'Potim', 'Praia Grande', 'Queluz', 'Redencao da Serra', 'Ribeirao Pires', 'Rio Grande da Serra',
    'Roseira', 'Salesopolis', 'Salto', 'Salto de Pirapora', 'Santa Barbara do Oeste', 'Santa Branca', 'Santa Isabel', 'Santana de Parnaiba', 'Santo Andre',
    'Santo Antonio de Posse', 'Santo Antonio do Pinhal', 'Santos', 'Sao Bento do Sapucai', 'Sao Bernardo do Campo', 'Sao Caetano do Sul', 'Sao Jose do Barreiro',
    'Sao Jose dos Campos', 'Sao Lourenco da Serra', 'Sao Luiz do Paraitinga', 'Sao Miguel Arcanjo', 'Sao Paulo', 'Sao Roque', 'Sao Sebastiao', 'Sao Vicente',
    'Sarapui', 'Silveiras', 'Sorocaba', 'Sumare', 'Suzano', 'Taboao da Serra', 'Tapirai', 'Tatui', 'Taubate', 'Tiete', 'Tremembe', 'Ubatuba', 'Valinhos',
    'Vargem Grande Paulista', 'Vinhedo', 'Votorantim'
}

for de in municipios:
    url = 'http://www.emtu.sp.gov.br/emtu/home/home.asp?a=queroIrPara&cidadede=' + \
        urllib.parse.quote(de)
    with urllib.request.urlopen(url) as url:
        data = json.loads(url.read().decode())
        for para in data:
            para = para['municipio']
            url2 = 'http://www.emtu.sp.gov.br/Sistemas/linha/resultado.htm?cidadede=' + \
                urllib.parse.quote(de) + '&cidadeate=' + urllib.parse.quote(para) + '&pag=origemdestino.htm'
            print(url2)
        break
