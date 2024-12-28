import Highcharts from 'highcharts';

document.addEventListener('DOMContentLoaded', function () {
    fetch('/chart/event')
        .then(response => response.json())  // Convertir la réponse en JSON
        .then(data => {
            // Extraire les semaines et les quantités d'éléments
            const weeks = data.map(item => item.week);  // Extrait les semaines
            const qtyElements = data.map(item => item.qtyElement);  // Extrait les quantités

            // Créer le graphique Highcharts
            Highcharts.chart('chart-container', {
                chart: {
                    type: 'areaspline', // Type de graphique en colonnes
                    backgroundColor: 'transparent'
                },
                title: {
                    text: 'Evolution d\'événements par semaine'
                },
                xAxis: {
                    categories: weeks,  // Les semaines extraites
                    title: {
                        text: 'Semaine'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Nombre d\'événements'
                    }
                },
                series: [{
                    name: 'Événements',
                    data: qtyElements,  // Quantités extraites
                    color: 'green'
                }],
                credits: [
                    {
                        enabled: false
                    }
                ]
            });
        })
        .catch(error => console.error('Erreur de récupération des données:', error));
    fetch('/chart/poney')
        .then(response => response.json())  // Convertir la réponse en JSON
        .then(data => {
            // Extraire les noms des poneys, les semaines et les heures totales
            const poneys = [...new Set(data.map(item => item.nom))];  // Obtenir les noms des poneys distincts
            const weeks = [...new Set(data.map(item => item.year_week))];  // Obtenir les semaines distinctes

            // Préparer les séries de données par poney
            const seriesData = poneys.map(poney => {
                return {
                    name: poney,
                    data: weeks.map(week => {
                        // Trouver la donnée correspondant à ce poney et cette semaine
                        const entry = data.find(item => item.nom === poney && item.year_week === week);
                        // Si une entrée existe, retourner les heures, sinon retourner 0
                        return entry ? entry.total_hours : 0;
                    })
                };
            });

            // Créer le graphique Highcharts avec des colonnes empilées
            Highcharts.chart('chart-container2', {
                chart: {
                    type: 'line',  // Type de graphique en colonnes
                    backgroundColor: 'transparent'  // Arrière-plan transparent
                },
                title: {
                    text: 'Évolution des heures d\'événements par poney et par semaine'
                },
                xAxis: {
                    categories: weeks,  // Les semaines extraites
                    title: {
                        text: 'Semaine'
                    }
                },
                yAxis: {
                    min: 0,  // Commencer à 0 sur l'axe des Y
                    title: {
                        text: 'Total des heures'
                    },
                    stackLabels: {
                        enabled: true,  // Activer les labels sur chaque pile
                        style: {
                            fontWeight: 'bold',
                            color: 'gray'
                        }
                    }
                },
                series: seriesData,  // Les séries par poney avec leurs données
                credits: {
                    enabled: false  // Désactive les crédits Highcharts
                }
            });
        })
        .catch(error => console.error('Erreur de récupération des données:', error));
});
