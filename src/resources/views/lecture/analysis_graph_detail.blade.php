@extends('layout.sidebar_layout')

@section('title')
    통계
@endsection

@section('lecture.analysis.detail.script')
    const data = {!! json_encode($data) !!};

    console.log(data);

    data['order'].forEach((order, index) => {
        switch(data['layout'][index]) {
            case 'line_graph':
                handleBarChart(data.data[order], order)
                break;
            case 'donut_chart':
                handleDonutChart(data.data[order], order);
                break;
            case 'pie_chart':
                handlePieChart(data.data[order], order);
                break;
        }

    });
@endsection

<script>
    const handleBarChart = (data, id) => {
            //remove following test data set when it use
            // console.log(data);

            // const
            //     data = [
            //       {name:'그들은 어디에 있나요?', value:69, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-54-5fba7f4ac7faf.jpeg', isRightAnswer: false, selectedAnswer: false },
            //       {name:'그들은 어디에 있나요?', value:42, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-55-5fba7f5567f37.jpeg', isRightAnswer: false, selectedAnswer: false },
            //       {name:'C', value:29, image:null, isRightAnswer: false, selectedAnswer: false },
            //       {name:'D', value:39, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-54-5fba7f4ac7faf.jpeg', isRightAnswer: false, selectedAnswer: false },
            //       // {name:'E', value:29, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-55-5fba7f5567f37.jpeg', isRightAnswer: true, selectedAnswer: false },
            //       // {name:'F', value:19, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-78-5fbb4fce6f529.jpeg', isRightAnswer: false, selectedAnswer: false },
            //       // {name:'G', value:9 , image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-79-5fbb4fd39c2d9.jpeg', isRightAnswer: false, selectedAnswer: false },
            //     ];


        const color = [
            `#87B8EF`,
            `#FDD465`,
            `#FF7794`,
            `#B282D1`,
            `#8993D3`,
            `#72C5CA`,
            `#666666`
        ];

        let margin = ({top: 20, right: 0, bottom: 30, left: 0})
        let height = 250
        let width = 600
        // let color = "steelblue"

        let y = d3.scaleLinear()
            .domain([0, d3.max(data, d => d.value)]).nice()
            .range([height - margin.bottom, margin.top])

        let x = d3.scaleBand()
            .domain(d3.range(data.length))
            .range([margin.left, width - margin.right])
            .padding(0.1)

        let yAxis = g => g
            .attr("transform", `translate(${margin.left},0)`)
            .call(d3.axisLeft(y).ticks(null, data.format))
            .call(g => g.select(".domain").remove())
            .call(g => g.append("text")
                .attr("x", -margin.left)
                .attr("y", 10)
                .attr("fill", "currentColor")
                .attr("text-anchor", "start")
                .text(data.y))

        let xAxis = g => g
            .attr("transform", `translate(0,${height - margin.bottom})`)
            .call(d3.axisBottom(x).tickFormat(i => data[i].name).tickSizeOuter(0))

        const clear = d3.select(`#graph-${id}`/*'svg'*/).selectAll('*').remove();

        const svg = d3.select(`#graph-${id}`/*'svg'*/)
            .attr("viewBox", [0, 0, width, height]);

        function rightRoundedRect(x, y, width, height, radius) {
            return "M" + x + "," + (y + radius)
                + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + -radius
                + "h" + (width - radius * 2)
                + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + radius
                + "v" + (height - radius)
                + "h" + ( - width)
                + "z";
        }

        svg.append('g')
            .selectAll('path').data(data).enter().append('path')
            .attr('fill', (d, i) => {
                if (color.length <= i) {
                    return color[5];
                }
                return color[i];
            })
            .attr("d", (d, i) => {
                return !d.value ? '' : rightRoundedRect(x(i) + (x.bandwidth() / 2 - 10), y(d.value), 16, y(0) - y(d.value), 8)
            });

        svg.append("g")
            .call(xAxis);

        svg.selectAll('line').each(function (d, i) {
            d3.select(this)
                .attr('class', 'dn');
        })

        svg.selectAll('text').each(function (d, i) {
            d3.select(this)
                .attr('stroke', () => {
                    return `#828291`;
                })
                .attr('y', function () {  return 10  })
                .attr('font-size', '16px')
        })

        svg.selectAll('.tick').each(function (d, i) {
            d3.select(this)
                .append('text')
                .text(() => {console.log(data[i]); return data[i].value;})
                .attr('x', 0)
                .attr('y', -(y(0) -y(data[i].value)) - 7)
                .attr("stroke", "#828291")
                .attr('font-size', '16px')
                .attr("text-anchor", "middle")
            ;
        })

        svg.select('.domain').attr('stroke', `#d5d5de`);
    }

    const handleDonutChart = (data, id) => {
        // const color = d3.scaleOrdinal()
        //     .domain(data.map(d => d.value))
        //     .range(["#96caff", "#faff16", "#fda899", "#13fcbb", "#eba6ff", "#bcca83", "#57e502", "#feaf23", "#c6c0cb", "#38f1fd", "#9ccfbe", "#f9feae", "#a6fe8e", "#bfcd03", "#ebd3b6", "#fec0df", "#c2eefc", "#cac2fc", "#bcfcd6", "#f4e5ff", "#f9dc56", "#80da93", "#ebb678", "#b1fb27", "#30dfc8", "#8dd0df", "#1ff479", "#cedbd8", "#d2e6b8", "#85feea", "#97db5c", "#deb7b7", "#cad5ef", "#d0eb6d", "#fe9fe1", "#bdc7ad", "#fcdadf", "#d9bae2", "#dac05a", "#ecda91", "#fef5d0", "#ffa4bc", "#43d9fd", "#d2fcf5", "#b1c7d0", "#e6f0fb", "#83e5bd", "#b2e598", "#fdfb73", "#73fd58", "#a6cfa2", "#a1e3e1", "#e4e21c", "#8ef8b0", "#e2c30e", "#fdc7ff", "#cefeb9", "#0be597", "#d4c491", "#fdc5b5", "#e4fdde", "#d5ccc7", "#acdaf8", "#e4c9da", "#fdc664", "#badfc5", "#bbd15f", "#fdf1f7", "#b4c3ed", "#93e8fd", "#ddd9e3", "#e5e5d7", "#98e116", "#e0d0fb", "#fccd95", "#aafdfe", "#5cd9de", "#deba9d", "#dce994", "#d6b2fb", "#c5bedd", "#bec4c3", "#feab79", "#82ea7f", "#fed7f3", "#8affd2", "#d6fc50", "#e8aed9", "#f7b7c2", "#2bf4e5", "#ffad53", "#11ff13", "#d3fe94", "#c2e530", "#aef161", "#fee5d4", "#a3d378", "#dad351", "#fec328", "#a4e3b3", "#a9efd9", "#feeb8a", "#85d4cd", "#e0b4c9", "#55e358", "#bddbe1", "#48ffa0", "#d6eee1", "#fee3b0", "#ff99fd", "#3fe0b0", "#84d7fe", "#7be9d3", "#1bf3cd", "#d4d4af", "#d6d278", "#70fffe", "#aac8e1", "#ffb0fe", "#b5ccbf", "#c6ccd5", "#ccd9c5", "#feee3e", "#cdc0ab", "#58e182", "#e9b8f8", "#f7bc97", "#b4e275", "#bee8e1", "#e1e3ff", "#ebebb2", "#8fd4af", "#c0d3a2", "#e7c67d", "#6ceba9", "#d8cde4", "#eacdc6", "#d4eef1", "#e7e8e9", "#7deaec", "#88f31d", "#c0efbe", "#75d8be", "#a0d1d3", "#fdacd4", "#09f64f", "#c4dc8c", "#d0d1fc", "#ecccf1", "#f7d517", "#d0dde8", "#e7dadc", "#78fe8b", "#e6e373", "#cde5fd", "#b1fead", "#e7fec5", "#e9fdfd", "#b9c3d9", "#cebec1", "#eab3a4", "#edb84a", "#8aea52", "#bad5fd", "#a7ddea", "#f9c9d5", "#f2deec", "#fbf4e7", "#b3d8cf", "#feb9ed", "#96e89d", "#d5d99c", "#efd16f", "#ecfb92", "#d0bbd2", "#89d97b", "#cdc47c", "#acd345", "#21e0f4", "#9ed693", "#9adfcd", "#ccdc4c", "#e3e3c2", "#d8f003", "#e7f158", "#b8fff2", "#cdb9e9", "#faa8ae", "#cac75c", "#d7d119", "#eccb48", "#bbd7ea", "#a0f3c1", "#cbeaa6", "#c5f4e0", "#ede9f5", "#b8bffd", "#97cced", "#70dba6", "#72dbf2", "#e6bddd", "#ddc2fe", "#b8ddb0", "#e7d29e", "#c7ec8c", "#d1edce", "#c8fb75", "#f9ffe8", "#e9abeb", "#b5d1b3", "#feb6af", "#ffba6e", "#92f772", "#e8f4cb", "#ffeda8", "#e5ff77", "#f6f8fe", "#c4c699", "#c5ca3f", "#e9bb29", "#19e2dc", "#d9bfb4", "#c6cabf", "#e6c091", "#bcd0d0", "#d5cbd3", "#aae346", "#d0d2d3", "#f1c7ab", "#72ef95", "#cdda6f", "#d9d5c0", "#a2eb81", "#72f3cc", "#91efe6", "#fed284", "#a6edf6", "#4bfee0", "#9bfb4f", "#c1f3f6", "#e0f9ab", "#d4ffd2", "#fffac1", "#a9c5fd", "#f0acc4", "#7adf34", "#a8d516", "#86dade", "#6cdfd7", "#a7d5b9", "#b4d899", "#f1c0bf", "#a9e8c7", "#e6e04c", "#fcd4bf", "#67feb6", "#ddfeee", "#f5af92", "#a7cddc", "#c7cae9", "#e1c2c9", "#06f6a4", "#64f36c", "#ffd056", "#e9d3ea", "#94f595", "#eadbcc", "#acf2b2", "#a2fde0", "#f5e5c6", "#f7eb67", "#f1e9e6", "#e2efdb", "#fbfd52", "#aacac8", "#6fdf6e", "#23e83d", "#d6c33e", "#edbb66", "#96d8f1", "#d9c9a7", "#30ef8c", "#66ed41", "#eabeed", "#c3dbce", "#d6d6e9", "#f8c6ee", "#d5d9d1", "#96f0cc", "#c7ef56", "#8ef6ff", "#aff0e8", "#b7f593", "#dee7e0", "#bdff5c", "#eff01a", "#d7f0fe", "#bdfdc3", "#f0ef9c", "#d3fe14", "#bec0ea", "#c6c2be", "#eab1b3", ]);
        // const color = d3.scaleOrdinal()
        //     .domain(data.sort((a,b) => b.value - a.value).map(d => d.value))
        //     .range(d3.quantize(t => d3.interpolateSpectral(t * 0.9 + 0.1), data.length + 1).reverse());

        const color = [
            `#87B8EF`,
            `#FDD465`,
            `#FF7794`,
            `#B282D1`,
            `#8993D3`,
            `#72C5CA`,
            `#666666`
        ];

        //test dataset
        // data = [
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 2},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        // ];

        const width = 300;//500;
        const height = 300;//Math.min(width, this.graphContainer.clientHeight);
        const arc = d3.arc()
            .innerRadius((Math.min(width, height) - 50) / 4)
            .outerRadius((Math.min(width, height) - 50) / 2 - 1);
        const innerArc = d3.arc()
            .innerRadius((Math.min(width, height) - 50) / 2 - 1)
            .outerRadius((Math.min(width, height) - 50) / 2 - 1);
        const outerArc  = d3.arc()
            .innerRadius((Math.min(width, height) - 50) / 2 * 1.1)
            .outerRadius((Math.min(width, height) - 50) / 2 * 1.1);

        const radius = (Math.min(width, height) - 50) / 2 * 1.25//0.8;

        const arcLabel = (() => {
            const radius = (Math.min(width, height) - 50) / 2 * 1.45//0.8;
            return d3.arc().innerRadius(radius).outerRadius(radius);
        })();
        const pie = d3.pie()
            // .sort((a, b) => b.value - a.value)
            // data의 value 큰값 > 작은값 순으로 정렬합니다. ex. 반대 순서는 a.value - b.value
            .value(d => d.value);
        const arcs = pie(data);
        const clear = d3.select(`#graph-${id}`/*'svg'*/).selectAll('*').remove();
        const svg = d3.select(`#graph-${id}`/*'svg'*//*'#graph'*/).attr('viewBox', [-width / 2, -height / 2, width, height])
            // .style('width', width).style('height', height)
            .attr('text-anchor', 'middle')
            // text-anchor 텍스트의 정렬을 설정합니다 ( start | middle | end | inherit )
            .style('font-size', '12px sans-serif');
        // const g = svg.append('g')
        //     .attr('transform', `translate(${width/2}, ${height/2})`);
        // 우선 차트를 그릴 그룹 엘리먼트를 추가합니다.
        // 위치값을 각각 2로 나누는건 반지름 값을 기준으로 한바퀴 돌며 path를 그리기 때문인거 같습니다.
        svg.append('g').selectAll('path')
            .data(arcs)
            .enter().append('path')
            // 이전과 동일하게 가상 path 요소를 만들고 그래프 데이터와 매핑하여 엘리먼트를 추가합니다.
            .attr('fill', (d, i) => color.length > i ? color[i] : color[6])//{  console.log(d, i); if (color.length <= i) { console.log(color[i]); return color[i]; } else { console.log(color[i]); return color[5]; } })//d => color(d.data.value))//d => d.data.color)
            // 다른 그래프와 다르게 .data 라는 객체가 추가되어 있는데, 위에 arcs 변수를 선언할때
            // .pie(data)가 {data, value, index, startAngle, endAngle, padAngle} 의 값을 가지고 있습니다.
            .attr('stroke', 'white')
            .attr('d', arc)
            // .on("mouseover", (d) => { this.tooltip.style.display = null; })
            // .on("mouseout",  () => { this.tooltip.style.display = "none"; })
            // .on("mousemove", (d) => {
            //     this.tooltip.style.left = (d.pageX+10)+"px";
            //     this.tooltip.style.top = (d.pageY-10)+"px";
            //     this.tooltip.innerHTML = `${d.target.__data__.data.name}: ${d.target.__data__.data.value}`;
            // })
        // .append('title')
        // .text(d => `${d.data.name}: ${d.data.value}`);
        // 각각 페스의 자식으로 title의 엘리먼트에 텍스트로 출력합니다.
        // 실제로 뷰에 출력되지는 않지만 시멘틱하게 각각의 요소의 설명 문자열을 제공합니다.
        svg
            .selectAll('allPolylines')
            .data(arcs)
            .enter()
            .append('polyline')
            .attr("stroke", "#828291")
            .style("fill", "none")
            .attr("stroke-width", 1)
            .attr('points', function(d) {
                if (d.data.value) {
                    var posA = innerArc.centroid(d) // line insertion in the slice
                    var posB = outerArc.centroid(d) // line break: we use the other arc generator that has been built only for that
                    var posC = outerArc.centroid(d); // Label position = almost the same as posB
                    var midangle = d.startAngle + (d.endAngle - d.startAngle) / 2 // we need the angle to see if the X position will be at the extreme right or extreme left
                    posC[0] = radius * 0.95 * (midangle < Math.PI ? 1 : -1); // multiply by 1 or -1 to put it on the right or on the left
                    return [posA, posB, posC]
                }
            })

        svg
            .selectAll('allLabels')
            .data(arcs)
            .enter()
            .append('text')
            .text( function(d) { return d.data.value ? `${d.data.name} ${d.data.value}` : `` } )
            .attr('transform', function(d) {
                var pos = outerArc.centroid(d);
                var midangle = d.startAngle + (d.endAngle - d.startAngle) / 2
                pos[0] = radius * 0.99 * (midangle < Math.PI ? 1 : -1);
                pos[1] = pos[1] + 4;
                return 'translate(' + pos + ')';
            })
            .attr('fill', '#828291')
            .style('text-anchor', function(d) {
                var midangle = d.startAngle + (d.endAngle - d.startAngle) / 2
                return (midangle < Math.PI ? 'start' : 'end')
            })
            .style('font-weight', 'bold')
            .style('font-size', '16px')
        // const text = svg.selectAll('text')
        //     .data(arcs)
        //     .enter().append('text')
        //     .attr('transform', d => `translate(${arcLabel.centroid(d)})`)
        //     .attr('dy', '0.35em');
        // // 라벨을 취가하기 위한 text 엘리먼트를 만들고 위치를 지정합니다.
        // text.append('tspan')
        //     .attr('x', 0)
        //     .attr('y', '-0.7em')
        //     .style('font-weight', 'bold')
        //     .text(d => d.data.value ? `${d.data.name} ${d.data.value}` : '')
        // 해당 데이터 항목의 이름을 두꺼운 글씨로 출력합니다. ex. A
        // text.filter(d => (d.endAngle - d.startAngle > 0.25)).append('tspan')
        //     .attr('x', 0)
        //     .attr('y', '0.7em')
        //     .attr('fill-opacity', 0.7)
        //     .text(d => d.data.value);
        // 해당 데이터의 수치값을 투명도를 주어 출력합니다. ex. 1000
        // svg.node();
        // d3.select('svg').appendChild(svg.node());
    }

    const handlePieChart = (data, id) => {
        // const color = d3.scaleOrdinal()
        //     .domain(data.map(d => d.value))
        //     .range(["#96caff", "#faff16", "#fda899", "#13fcbb", "#eba6ff", "#bcca83", "#57e502", "#feaf23", "#c6c0cb", "#38f1fd", "#9ccfbe", "#f9feae", "#a6fe8e", "#bfcd03", "#ebd3b6", "#fec0df", "#c2eefc", "#cac2fc", "#bcfcd6", "#f4e5ff", "#f9dc56", "#80da93", "#ebb678", "#b1fb27", "#30dfc8", "#8dd0df", "#1ff479", "#cedbd8", "#d2e6b8", "#85feea", "#97db5c", "#deb7b7", "#cad5ef", "#d0eb6d", "#fe9fe1", "#bdc7ad", "#fcdadf", "#d9bae2", "#dac05a", "#ecda91", "#fef5d0", "#ffa4bc", "#43d9fd", "#d2fcf5", "#b1c7d0", "#e6f0fb", "#83e5bd", "#b2e598", "#fdfb73", "#73fd58", "#a6cfa2", "#a1e3e1", "#e4e21c", "#8ef8b0", "#e2c30e", "#fdc7ff", "#cefeb9", "#0be597", "#d4c491", "#fdc5b5", "#e4fdde", "#d5ccc7", "#acdaf8", "#e4c9da", "#fdc664", "#badfc5", "#bbd15f", "#fdf1f7", "#b4c3ed", "#93e8fd", "#ddd9e3", "#e5e5d7", "#98e116", "#e0d0fb", "#fccd95", "#aafdfe", "#5cd9de", "#deba9d", "#dce994", "#d6b2fb", "#c5bedd", "#bec4c3", "#feab79", "#82ea7f", "#fed7f3", "#8affd2", "#d6fc50", "#e8aed9", "#f7b7c2", "#2bf4e5", "#ffad53", "#11ff13", "#d3fe94", "#c2e530", "#aef161", "#fee5d4", "#a3d378", "#dad351", "#fec328", "#a4e3b3", "#a9efd9", "#feeb8a", "#85d4cd", "#e0b4c9", "#55e358", "#bddbe1", "#48ffa0", "#d6eee1", "#fee3b0", "#ff99fd", "#3fe0b0", "#84d7fe", "#7be9d3", "#1bf3cd", "#d4d4af", "#d6d278", "#70fffe", "#aac8e1", "#ffb0fe", "#b5ccbf", "#c6ccd5", "#ccd9c5", "#feee3e", "#cdc0ab", "#58e182", "#e9b8f8", "#f7bc97", "#b4e275", "#bee8e1", "#e1e3ff", "#ebebb2", "#8fd4af", "#c0d3a2", "#e7c67d", "#6ceba9", "#d8cde4", "#eacdc6", "#d4eef1", "#e7e8e9", "#7deaec", "#88f31d", "#c0efbe", "#75d8be", "#a0d1d3", "#fdacd4", "#09f64f", "#c4dc8c", "#d0d1fc", "#ecccf1", "#f7d517", "#d0dde8", "#e7dadc", "#78fe8b", "#e6e373", "#cde5fd", "#b1fead", "#e7fec5", "#e9fdfd", "#b9c3d9", "#cebec1", "#eab3a4", "#edb84a", "#8aea52", "#bad5fd", "#a7ddea", "#f9c9d5", "#f2deec", "#fbf4e7", "#b3d8cf", "#feb9ed", "#96e89d", "#d5d99c", "#efd16f", "#ecfb92", "#d0bbd2", "#89d97b", "#cdc47c", "#acd345", "#21e0f4", "#9ed693", "#9adfcd", "#ccdc4c", "#e3e3c2", "#d8f003", "#e7f158", "#b8fff2", "#cdb9e9", "#faa8ae", "#cac75c", "#d7d119", "#eccb48", "#bbd7ea", "#a0f3c1", "#cbeaa6", "#c5f4e0", "#ede9f5", "#b8bffd", "#97cced", "#70dba6", "#72dbf2", "#e6bddd", "#ddc2fe", "#b8ddb0", "#e7d29e", "#c7ec8c", "#d1edce", "#c8fb75", "#f9ffe8", "#e9abeb", "#b5d1b3", "#feb6af", "#ffba6e", "#92f772", "#e8f4cb", "#ffeda8", "#e5ff77", "#f6f8fe", "#c4c699", "#c5ca3f", "#e9bb29", "#19e2dc", "#d9bfb4", "#c6cabf", "#e6c091", "#bcd0d0", "#d5cbd3", "#aae346", "#d0d2d3", "#f1c7ab", "#72ef95", "#cdda6f", "#d9d5c0", "#a2eb81", "#72f3cc", "#91efe6", "#fed284", "#a6edf6", "#4bfee0", "#9bfb4f", "#c1f3f6", "#e0f9ab", "#d4ffd2", "#fffac1", "#a9c5fd", "#f0acc4", "#7adf34", "#a8d516", "#86dade", "#6cdfd7", "#a7d5b9", "#b4d899", "#f1c0bf", "#a9e8c7", "#e6e04c", "#fcd4bf", "#67feb6", "#ddfeee", "#f5af92", "#a7cddc", "#c7cae9", "#e1c2c9", "#06f6a4", "#64f36c", "#ffd056", "#e9d3ea", "#94f595", "#eadbcc", "#acf2b2", "#a2fde0", "#f5e5c6", "#f7eb67", "#f1e9e6", "#e2efdb", "#fbfd52", "#aacac8", "#6fdf6e", "#23e83d", "#d6c33e", "#edbb66", "#96d8f1", "#d9c9a7", "#30ef8c", "#66ed41", "#eabeed", "#c3dbce", "#d6d6e9", "#f8c6ee", "#d5d9d1", "#96f0cc", "#c7ef56", "#8ef6ff", "#aff0e8", "#b7f593", "#dee7e0", "#bdff5c", "#eff01a", "#d7f0fe", "#bdfdc3", "#f0ef9c", "#d3fe14", "#bec0ea", "#c6c2be", "#eab1b3", ]);
        // const color = d3.scaleOrdinal()
        //     .domain(data.sort((a,b) => b.value - a.value).map(d => d.value))
        //     .range(d3.quantize(t => d3.interpolateSpectral(t * 0.9 + 0.1), data.length + 1).reverse());

        const color = [
            `#87B8EF`,
            `#FDD465`,
            `#FF7794`,
            `#B282D1`,
            `#8993D3`,
            `#72C5CA`,
            `#666666`
        ];

        //test dataset
        // data = [
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 2},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        //     {name: 'test', value: 1},
        // ];

        const width = 300;//500;
        const height = 300;//Math.min(width, this.graphContainer.clientHeight);
        const arc = d3.arc()
            .innerRadius(0)//(Math.min(width, height) - 50) / 4)
            .outerRadius((Math.min(width, height) - 50) / 2 - 1);
        const innerArc = d3.arc()
            .innerRadius((Math.min(width, height) - 50) / 2 - 1)
            .outerRadius((Math.min(width, height) - 50) / 2 - 1);
        const outerArc  = d3.arc()
            .innerRadius((Math.min(width, height) - 50) / 2 * 1.1)
            .outerRadius((Math.min(width, height) - 50) / 2 * 1.1);

        const radius = (Math.min(width, height) - 50) / 2 * 1.25//0.8;

        const arcLabel = (() => {
            const radius = (Math.min(width, height) - 50) / 2 * 1.45//0.8;
            return d3.arc().innerRadius(radius).outerRadius(radius);
        })();
        const pie = d3.pie()
            // .sort((a, b) => b.value - a.value)
            // data의 value 큰값 > 작은값 순으로 정렬합니다. ex. 반대 순서는 a.value - b.value
            .value(d => d.value);
        const arcs = pie(data);
        const clear = d3.select(`#graph-${id}`/*'svg'*/).selectAll('*').remove();
        const svg = d3.select(`#graph-${id}`/*'svg'*//*'#graph'*/).attr('viewBox', [-width / 2, -height / 2, width, height])
            // .style('width', width).style('height', height)
            .attr('text-anchor', 'middle')
            // text-anchor 텍스트의 정렬을 설정합니다 ( start | middle | end | inherit )
            .style('font-size', '12px sans-serif');
        // const g = svg.append('g')
        //     .attr('transform', `translate(${width/2}, ${height/2})`);
        // 우선 차트를 그릴 그룹 엘리먼트를 추가합니다.
        // 위치값을 각각 2로 나누는건 반지름 값을 기준으로 한바퀴 돌며 path를 그리기 때문인거 같습니다.
        svg.append('g').selectAll('path')
            .data(arcs)
            .enter().append('path')
            // 이전과 동일하게 가상 path 요소를 만들고 그래프 데이터와 매핑하여 엘리먼트를 추가합니다.
            .attr('fill', (d, i) => color.length > i ? color[i] : color[6])//{  console.log(d, i); if (color.length <= i) { console.log(color[i]); return color[i]; } else { console.log(color[i]); return color[5]; } })//d => color(d.data.value))//d => d.data.color)
            // 다른 그래프와 다르게 .data 라는 객체가 추가되어 있는데, 위에 arcs 변수를 선언할때
            // .pie(data)가 {data, value, index, startAngle, endAngle, padAngle} 의 값을 가지고 있습니다.
            .attr('stroke', 'white')
            .attr('d', arc)
        // .on("mouseover", (d) => { this.tooltip.style.display = null; })
        // .on("mouseout",  () => { this.tooltip.style.display = "none"; })
        // .on("mousemove", (d) => {
        //     this.tooltip.style.left = (d.pageX+10)+"px";
        //     this.tooltip.style.top = (d.pageY-10)+"px";
        //     this.tooltip.innerHTML = `${d.target.__data__.data.name}: ${d.target.__data__.data.value}`;
        // })
        // .append('title')
        // .text(d => `${d.data.name}: ${d.data.value}`);
        // 각각 페스의 자식으로 title의 엘리먼트에 텍스트로 출력합니다.
        // 실제로 뷰에 출력되지는 않지만 시멘틱하게 각각의 요소의 설명 문자열을 제공합니다.
        svg
            .selectAll('allPolylines')
            .data(arcs)
            .enter()
            .append('polyline')
            .attr("stroke", "#828291")
            .style("fill", "none")
            .attr("stroke-width", 1)
            .attr('points', function(d) {
                if (d.data.value) {
                    var posA = innerArc.centroid(d) // line insertion in the slice
                    var posB = outerArc.centroid(d) // line break: we use the other arc generator that has been built only for that
                    var posC = outerArc.centroid(d); // Label position = almost the same as posB
                    var midangle = d.startAngle + (d.endAngle - d.startAngle) / 2 // we need the angle to see if the X position will be at the extreme right or extreme left
                    posC[0] = radius * 0.95 * (midangle < Math.PI ? 1 : -1); // multiply by 1 or -1 to put it on the right or on the left
                    return [posA, posB, posC]
                }
            })

        svg
            .selectAll('allLabels')
            .data(arcs)
            .enter()
            .append('text')
            .text( function(d) { return d.data.value ? `${d.data.name} ${d.data.value}` : `` } )
            .attr('transform', function(d) {
                var pos = outerArc.centroid(d);
                var midangle = d.startAngle + (d.endAngle - d.startAngle) / 2
                pos[0] = radius * 0.99 * (midangle < Math.PI ? 1 : -1);
                pos[1] = pos[1] + 4;
                return 'translate(' + pos + ')';
            })
            .attr('fill', '#828291')
            .style('text-anchor', function(d) {
                var midangle = d.startAngle + (d.endAngle - d.startAngle) / 2
                return (midangle < Math.PI ? 'start' : 'end')
            })
            .style('font-weight', 'bold')
            .style('font-size', '16px')
        // const text = svg.selectAll('text')
        //     .data(arcs)
        //     .enter().append('text')
        //     .attr('transform', d => `translate(${arcLabel.centroid(d)})`)
        //     .attr('dy', '0.35em');
        // // 라벨을 취가하기 위한 text 엘리먼트를 만들고 위치를 지정합니다.
        // text.append('tspan')
        //     .attr('x', 0)
        //     .attr('y', '-0.7em')
        //     .style('font-weight', 'bold')
        //     .text(d => d.data.value ? `${d.data.name} ${d.data.value}` : '')
        // 해당 데이터 항목의 이름을 두꺼운 글씨로 출력합니다. ex. A
        // text.filter(d => (d.endAngle - d.startAngle > 0.25)).append('tspan')
        //     .attr('x', 0)
        //     .attr('y', '0.7em')
        //     .attr('fill-opacity', 0.7)
        //     .text(d => d.data.value);
        // 해당 데이터의 수치값을 투명도를 주어 출력합니다. ex. 1000
        // svg.node();
        // d3.select('svg').appendChild(svg.node());
    }
</script>

@section('content')
    <ul class="tab-menu">
        <li class="tab-menu__item"><a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a></li>
        <li class="tab-menu__item"><a href="{{ route('class.mainView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}">수업</a></li>
        <li class="tab-menu__item active"><a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a></li>
    </ul>
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home"></li>
            <li class="page-nav__item">내 강의실</li>
            <li class="page-nav__item">수업</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content exist-tab analysis__wrap">
            <h3 class="analysis__tit">{{ $class->name }}</h3>
            <ul class="tab-menu2">
                <li class="tab-menu2__item active"><a href="{{ route('lecture.analysis.graph.detailView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}">그래프</a></li>
                <li class="tab-menu2__item"><a href="{{ route('lecture.analysis.list.detailView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}">목록</a></li>
            </ul>
            <ul class="analysis__list">
                @php
                    $index = 0;
                @endphp
                @foreach($data['order'] as $order)
                    <li class="analysis__item">
                        <span class="badge">슬라이드{{ $data['num'][$index] }}</span>
                        <h4 class="sub">{{ $data['question'][$index] }}</h4>
                        <div class="graph-wrap">
                            <svg id="graph-{{ $order }}" width="600px" height="300px"></svg>
                        </div>
                    </li>
                    @php
                        $index += 1;
                    @endphp
                @endforeach
            </ul>
        </div>
    </div>
@endsection