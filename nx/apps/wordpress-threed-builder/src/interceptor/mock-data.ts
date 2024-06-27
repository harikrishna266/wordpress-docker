export const sampleData = {
  '/wp-admin/admin-ajax.php?action=get_all_designs' : [
    {
      "id": "1",
      "name": "Design 1",
      "model_id": "1",
      "user": "1",
      imageUrl:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/DESIGN-1.png',

      layers: [
        {
          id: 1,
          name: 'layer_1',
          url: 'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-1.txt',
          color: 'red',
          allowPattern: true,

        },
        {
          id: 2,
          name: 'layer_2',
          url: 'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-2.txt',
          color: 'green',
        },
        {
          id:3,
          name:'layer3',
          url:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-3.txt',
          color:' yellow'
        },
        {
          id:4,
          name:'layer4',
          url:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/layer-4.txt',
          color:' yellow'
        },
        {
          id:5,
          name:'Stitches',
          url:'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/T-Shirt-EXPEDITION/T-Shirt-EXPEDITION/DESIGNS/DESIGN-1/layers/text-layer/stitches.txt',
          color:' yellow'
        }
      ],
    },

  ],
  '/wp-admin/admin-ajax.php?action=get_all_patterns': [
    {
      "id": "1",
      "name": "cross-desgin",
      url: 'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/tiger/parrterns/text/PARRTERN-2.txt'
    },
    {
      "id": "2",
      "name": "cross-desgin",
      url: 'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/tiger/parrterns/text/PARRTERN-3.txt',
    },
    {
      "id": "2",
      "name": "cross-desgin",
      url: 'https://raw.githubusercontent.com/ARRAYGEEK/graphics-design-/tiger/parrterns/text/PARRTERN-4.txt',
    }
  ]
}
