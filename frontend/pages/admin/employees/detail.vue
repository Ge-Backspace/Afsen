<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <h1 class="heading">Detail Laporan</h1>
          <el-row>
            <el-col>
              <el-card style="max-height:10%">
                <el-row :gutter="20">
                  <!-- <el-col :md="6">
                    <img style="width:100%; height:auto"
                      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA3oAAAH0CAMAAABcqK/LAAAAYFBMVEWwHUf/31Vkwv/QLF8AbLX0okLuSnzO4fD06bj6yUft2qQflOPdvpDx4q/2s0k8fKhAksPxxW7701PCW3+hP3NsmavZ38vfPnHy2IO9patfrtvniI+LyOfLpGm0y8SWnYx3HGzXAAAbSElEQVR42uyd7WKiShZFNVcdxC4NmtBEbd//MScmmogUVFHUF8Vav2Zu98yltVfO3pxCZ/8DgADMeAkAUA8A9QAA9QBQDwBQDwD1AAD1AFAPAFAPAPUAUA8AUA8A9QAA9QBQDwBQDwD1AAD1AFAPAFAPAPUAUA8AUA8A9QAA9QBQDwBQDwD1AAD1AFAPAFAPAPUAUA8AUA8A9QAA9QBQDwBQDwD1AAD1AFAPAFAPAPUAUA8AUA8A9QAA9QBQDwBQDwD1AAD1AFAPAFAPAPUAUA8AUA8A9QAA9QBQDwBQDwD1AAD1AFAPAFAPAPUAUA8AUA8A9QAA9QBQDwBQDwD1AAD1AFAPPil5CVAPAohXzSvkQz3wTTW/kvNCoB74JJ/fYfChHvjLmvMHSJ2oB95KXh1SJ+qB16z5i+BlQT1wi5hLIXWiHnjNmg/y8eqgHvgXj8qHeuC15DH4UA9cjzyVePtiyauEeuA3a35SLJeoh3pgGbV42yXqoR74Lnnf4qEe6oHXkveVNVEP9SBAyUM91INAWRP1UA88Zs39w8hDPdSDAFkT9VAPLNFbPNRDPfBd8lAP9SBIyUM91IMgJQ/1UA8CZU3UQz0YhlCK1zLyUA/1IEDWRD3Ug1DioR7qgc+SV+T5FvVQD8xHntFCYZtnn1Soh3rgNWtW2Y0C9VAPDKjMsqbIfhAF6qEe+Cl5D+Jdybe8kqgHNkvevL3k1eEjqFEPHJe8bZVJQT7UA6dZM2sF+VAP1JidGnsueU/wsqIeOMmaeaaAwYd60IXVkod8qAcuS56WeMiHetCaNY1OjSlKHpUP9cBFySvyrB+80KgHw7Pmtsp6Q+pEPegjXjGk5CEf6oFR1hxe8kidqAeBSp6ZfExI1KPk9VuhW0mdOd/FjnrJjjyThcK2yixQal5bzruEemTNoSWvR+p8uDZSJ+olhtFj6NbE65avdm0V8qEeJS+zSql5bVQ+1JtMyZs7K3lK+aTXJnjPUI+S51S+1msjdaLeNLOmI/Ge3ev4oUDlQ71xY/QYuu2S1yKf4ocCiwbUm1jWdFHyJPJpFFDeQNQbKWYlL/NAWeosO3gHUY+SZ5lK62AN7yHqjTFrGp0ay72Il2suO3gXUY+S51e8LV9chHoTypp+xBM9TrTxRqJeauIVoUqeqPrkYN5K1Esqa8pKXhFXyUM91JtIycsjK3moh3qUvCAlD/VQb1wIk4VCjCUP9VAv+azpaYWemzy2hHqoNwpMHkPf5hGLp1Tv/HLmbUc9Sp7Nkqej3vnlCu886oXNmiZjpciiLXka6r3cYPChHiXPZtZUqHd++QX5UG9EWTPykqdQ71E83EO9QJg8hr6NveR1q/fSAPlQbxxZM/qS16Xe+UUG8qGeV1Itee3qycXjXifqUfLsiSdT76UDBh/qecqaBnluLCWvqd753DnykA/1oi551VhK3rN6X86pxCN1ol6kWXNEJa+u3o9zmyPyoV7k4hUjeRi2m7LR7zZq90idqBdVyfMknqWS9zD1nmMm8qEeJa8h3t5WyftRT9LvjkfcQz1K3uPdlb3NrPlFy42VDfKhnm9MHkP3dHelsC7ev/ZbmqRO1Is+a3oqedXeasm7infpNIt7najnD5NbGCMtecvlh0osUifqxVzyspGWPKV4L5vFhtSJejEsFOahSp7wWvJ+xFt8qqcjH3KgHiVv4H3NBxaLm3ocb0G92LKmp3PSVYCS9y3eTT1SJ+oFXCjITo2lXPLq6iEf6sWTNRMvec/qca8T9Sh5jkvecbGQqcfgQz1KntOSt1m0qYd8qOd1obAPVfLyECWvNvIa6nGvE/UoeU5K3rN4DfWofKhnB4NTY8Voj2uqN3mvC7V6pE7UC1Py8nRLnkQ8qXqbzZnUiXqeS16656QlWbNdPVIn6lHynJW8TvVInajnMWt6KnmFcuRtvZQ8hXocqkY9EwweQ4+n5C19lLzdpXxXqMeiAfV8ZM1oSt7Wunjvkln3fr2ay2u3eqRO1HO/UIil5G2tlzypePc/7kWhHvKhntuSJyIpeWv7d1d2TfFey5+fBVn2rlCP1Il6zhYK0ZS8tfWSJxNvd8lqP2nK43D5GHyTV4+Sp1fy6lyU8pE6Uc9+ycumWfKe5Bs++I7oM131DB5Dn1jJ25WtPxvOw+Q7Ll7RZ6rqGWTNhDd5LSUva/9R01n5jt2fVH09KYN6E1XPRDxK3uPY66p8N8E2XQt71JumegYLhWpiJa/UuNqz4h6LNHXeDoei3hTVM1go+Fqhx1LyLpoXfFTc3Ny0nspGvempZ5A1i2mVvMVF/5qfK1/j/3/TcjgU9SanXv+FQjyfeBRDyetcNCi+H+XxQSTUm5h60ZY8jU888lPyXsve135WLNI3sicAUW9S6lHybJW8+tV/pc6uRd6m+SAS6k1IvTGXvHV0Je/5bJni39Z46B31pqNe/6wZzwrdU8kznvBln0+OR71pqWfwGDolz514qDcV9ZRZk5JnnDWzi4F4TfVOq1OJUcmpZ1DyxnpOenkxKnnvxn+EUvd7+TrV+1hdOaFUWurFW/LWUyx5EvXK0+rGB1IlpJ4qbDay5paSp73RMxWvpt6PeFdInQmpt95X8WXNmEqecFXyWj9G91G9j1UdUmdC6q3XRaWbNUcrnv+SdzYreXX1ylUTUmdC6q3XldZj6JQ89yWvpt5pJQX5ElJPljpDlbx1LCXP4ULhuFio1WsR75o6qXzpqNeQrwj0zbCxlDzzU2PqhcLxdaFW72PVBZUvIfU+Kx8l77HkCVdZUy3eYrE7rRRcECwd9eb3wbeffMlzuFA4aoi3eFOJd5hR+NIJnF9/tStKntuSt7Mi3tsM9ZK5zdL+6ZoVJc/aqTGtrHlQj7wZ6qWiXvsHnEyu5DlcKBztiYd6aai3b+1TxcRK3usISt4M9VJRb9/69zyauyueSp7TU2NaWVMl3upthnqpqJe3pztKnueFwkF75KHe+NVrPTq9peT5LXmLXuKh3sjV6/xcCA9pU0RT8nbmJc/XQmE2Q71U1FM9qleJCZW8wAuFv33NQ70Rq6f+9L95Fbjkbf2UvPdRlTzUG7963Q/JOpYvhZLnfaGAeqmo1/KcXh03qbOIZpPn8tSY7YUC6qWjno58DipfEiUvXNZEvSTUW6/3vlNnvo1lk+ey5LlYKKBeWuqt1SPI5qIhopJXjrLkoV5C6mkMPmuVL5qStxthyfvvT3ZCvQT2eut1H/msVL5oSt5ijCXv9JUaeHIhpannqfJplLzoN3nhsubh/rPvD8/rpaWe89SZR1PyXqM/NdbcJxwe6/YJ9ZJSz23qFCmUPE+nxg6ykld/NU+ol0rXc506KXnaJe/vm7zk3aS7ZwjUS2nq6S0aqlGXvOhPjXVmTZHn+c+fAMNSmnp6k09Q8lwtFJpZ8/CQNfNv7q8/n0Gd1NTTmnx9Kp9OyVtGX/KiyJr5HYF8SU49u5VvGiXPzqkxiXhCIt4nv9eGZklNPS35tM6WVSmUvBgWCjXxan8UBl9SU0/vfoug5OmXvGELBSET7/6fkC+pqWeh8kW1yRNplLwH8cTDf8O1pKbe0MpXRFPy4j819tZ+aqyl5IknFbEtqak3pPJR8vQXCt2nxmQlTzIGSZ1JTT3j1OngYVjTkhf9l5c0S97sTya6S570lgvyJTX19OSLdpMXfKFgVPKERsmT3etEvrSmXv/KF1XJE6MreYqFQst67/ZLyJfU1Ot3tiyikhf9qbG3roWC6JE1f50UyJfS1OtR+dIoeXEvFDrE+/rniJeWelqpM4mSN4KFQkO8+jDEvIQCp6Z88ZS8BE+NiVxj5H3/CqEzqamnlTr3+xhK3oBTY1E8hi6bbkJoiXfXtyxL1EtJPR35gpe8dE+NqcWr3Y0pUS8l9VSpc7ts05OS52Kh0HkbVKBeIl1PLd91rrX8jhRKnvuFQjaw5D3/wxL10pl6Hanze65J9RxByTuHOjVmJ2sK6fFO1EtMPbl8N70kvyOFkmfl1JjBY+i6C4WWCVmiXmLqNTPlj16N3+Gr5A14NOgSQclTP6HQL2v2fqKhRL1A6n3aYy7fg17Pv4OSp7VQyE1OjelFUz3xVqtTiXqB1JvvTVPno151PX2VvKmeGtObkOq/CqevizyhXiD1+sq3l1W52u/wVvKmtFDIep6rVqfO0891fqCef/XuHvWV77nKDVBPXfJ23kueq1NjfrKmlnwftWstUS/I1OufOhuJ0lg905IX/NSY0WPopiNMeRtU8oEdoit1ls+Xe0K9QOr1lG9pST3DkrdL6DF004VCd9b8/ZqGsjtrJiXfGANnX/ksqWeY/JIveWJgybv/T4Q8dZ5arvoD9YJMvV6Vz4p6MZa8WB9D71fynn+xbC95q5Qq32inXo/BZ0G9f2Yr9PhPjfldKMhKXteGvey++BPqhZl62vINVm+sJW9hIF7bY+gDn1DozprPv1p2Z81fLqgXZOrpps6h6vkveVF8G7rlJxQU4j38K24PsavFO4z6G6PHPfX05BumnmnJE+4WCq6+vES5UBDmC4XOkvc0Ja8HXf5oiDebMfXCTT2d1DlEvUmVPOOFQt/boEq39cSbMfWCTj21fObq+S956SwUemTNhnjKrPn32zzUCzv1lO4ZqxdjyXu1Ip7BF+V5KHk3Tpojj8AZgXrd8hmqF6DkJfkYumbWNBCPqRc8cCrkM1LvI8KS5+ox9IP3U2ODSx7qRTP1uuQzUM+85Al3WTPQY+jusmZjSuqXPNSLSr029/qrZ1jy4j81dnBV8oYsFIRR1kS9mNRrka+vesmWPKunxjLbC4X+4qFeHF2vXb5+6pmWvOCnxiJ4DH3IQsFAPNSLaOpJj7f0Uc+w5I3z1FioJxSsZE3Ui0+9xuDTV++f/5IX7MtLPD+hkFtbKKBevOo9y6ev3vvZqOQldGpMaJgUeKGAejGrNzdVb3M89y15fNaY85L33wz10ldvszmO7NTY7v/tnd1S5DYQRl1lloLBZgjMRmHZhfd/yzAwC/Nj2ZKsllrS8R0Jldxw6vTXrZYETo0l2lBYVWuCXnXo3T388gh5bQ0Uom0oxAEP9CpD7x2+324hL/upsauIp8aWz1+uXUPfRAx5oFcnehdVpy3kFXhqLOm9tmvB23Wg1xp6J1Vn9JCXbw09+5VH8WpN0KsUvW/4agp5sg/lSZ8aA71G0DtEvtghT8VAQeqhPOcNhTjggV6t6L1HvgwhT+jUmIKBgvtq0HLIA73K0bvbqjw1lnQN3deQqWpN0KsbvRJD3nXMe22jnxqLCR7oNWS9h9cKQ17CK4+GqOCBXjPW2+o/NTZ5r+2YMOTNDRQihjzQa8p6DzcMFPTUmqCXEr3bvNb7+fNVCjyxU2M5HsqbZlsAPNBrxXpvw1tQk0XDQGHMfOXRIAEe6LWS9d6GYXh7jQ6e9jV019fQZ/4X8UMe6DVmvf3nV3XmC3lPwWvo0R7KE601Qa+lrPeB3vDscSFEEafGhAcKcuCBXlvW+4BvTBjy8q2hj24bCrOWHATBA72Wst7hc4l8JT5echNrNUg65IGe+PeYt+DcThScbvBlfA3dY6DgsKEwjsoGCqDXcMH5+c1GvmwhT9FDeeLggV7F1ruyWm9WfPlOjQmuoTtuKPy15CAPHug1aj0rfGWcGnO5XjN8oLAc8q53HehhvYCsZ4ePgUKSWhP02uxwHn3PI2vomcADvZatt2fvVfHjJRmuPBqSgQd6Cq33mCbrncGn7tRYgpC3yRPyQK8C692vtd4HfP9mDXl6NhReEioP9BrPel/my7iGnnJDYW6BNjF4oKfQeo8Js94neTyUlzTkgV5TbZY56z3bHwdzrjW3T8IDhZvMA4VdB3qFoveoNuu9ozf3KmaJAwXttSboNVRwzlvP/ipmA4+X5AEP9Bqf632jNw1f6oFC+g2FIRN4oEeb5Qu9y6ozxamx+jcUQK/tud6bA3pn4pMKebEGChHW0DOCB3pY7xi9Y/jE1tDVPJSXFTzQI+udond39zveQMFo3lAY8oIHenQ4z9Hbi6+ONfR1p8aMMHmgVzR69wLW2z9JK3PXmKINheVasxP/QI+C89nlUcysGwqbuBsKy+D1HehhPZXo7XZrHi/JW2sOKsADPdALQ6/fPdV6asx0HeiBXp6s54Jeb4VPfg39puyQB3pkvfA2yx69d/ji32sr+1CelloT9Cg411hvUnyza+i+5y8jr6GrAg/0JL9/khacbxnQO4dvl3ZDIXKtaboO9LBeGdY7rTo9To2FbsNWEfJArwLrZc56h+9J/722ympN0Kuqw/mWyXrm2uyrTrmBwvoNheVL/tKDB3rprOd8RURZBeehrVn0qTHTdaBXsfWc4ZtH7972b99yFJzGFpSOTo3dpF1DP7/OTF/IA73U1nOtOksZqR+Bd26OpZB303TIA7301nODL7DgTJ/1rH/DQ/aBwsGSOkMe6OWwnkvVmdx6Q1DBaWx/xwUNFEzXgV4z1luGrwjrGdufsp5aU23IA71M1lusOj3aLLlWZe0Xb9qucpd5vGQsMuSBXjbrLYhPv/Vml/UO8OXdUFAd8kAvo/Vm4Us+1xv80Fu8GmLIvqGgO+SBXk7rzcGX/zTLbMG53ZnFWm6TdQ19Gby+A712rWdnL3Cknsx603t6Z1VnjjcUxkJC3t/hJ+hlQ88Cn3LrXe23FYwjfMsXOoxjcyEP6+UuOG3wKc9628+DLMvwDRk2FIoIeaCnwHqTg4YCrHd+iswmvtVXHo1eVx4VEvJATwl6l+JLfXzaO+u5wzcmXEMvJuSR9bSgdw6f9g5n3/vAl2qgMJRUa2I9Leidwpd8pB5qPSf23iMfIQ/09KJ3HPkCD5Klznqe4hudF+wCHmUuK+RRcOpC70h8uq237Xt/+GRPjRUW8rCeMvS+4Cukw+kF3xCx1jyz5FBgrQl6ytA7VJ2PpXQ4vSLfRuhe21LBo+DUhd6n+Iqz3sTKum2jIfJAociQh/U0oreHr6QOp1/kW9/XrCLkYT2d6L3Dl7rDOcSwnlvki7mhMJRba2I9nejdprbecxTrOVWdX/A5DhRWnRrrdH9Yr2T0dFnPfcq3fqBQcsjDemWid68163kd7Gw65GE9rBffej5TvuANhaH4WhPrkfUiZz2PdaKQgUIlIQ/rFYHefUEdztCNBq9a86WGWhPrYb34Wc8bvvZCHtaroM2i1XoegwafDYWhlloT62E9kaznfrYs9kChK+nDenQ4ZaznerbMdUPhpaJaE+sx1xPLemHrRDOnxmoDD+sV1+EsyXpukW/TXq2J9WizSFsvcJ2oAfCwHm0WYes5Rr6xqVoT9LBeCusFrxNVDR4FZ9lZrwzruVWdQ0O1JtbDeoms5368pRnwsB5zvTTW81snGiuvNbFeQ3O9bX703AcNYwPggR5zvXUFp4kd+TYt1JqgR9ZbbT1zLRL5lk+NdcV/ZD2y3hr0Pm5BiQ1f9bUm1hP+/hNflRXKej4F57U/fNdrvxrAAz2st9p6qeEzXQd6oFdM1tuKZb0DDyZq1dn3L/WGPLJeEQVnIdaLG/n2XrP8Ql8NeVivtOGCxqwXuer8+MOcxLMi8ECPrBfLerGqzv6LvIv/fNeBHuhlKziVZr1YVecXXpe/0XWgB3qVn2YJR28tfN9/mOe/0XegB3rVW28bWHCujXz9BHmfv1EfeKCH9SJbLzzynUa5k1/pOtADPVXW+6Et662oOs/+MEEP9Ohw+qPnD18/Rx7ogV56692Xl/WC4Lv4wwQ90KvjIJmw9cz0abBw8kAP9LRZ71b1XC9YfB0FJ+hhvWjoecCH9UAP6wWjZ8Lho+AEvVqtt81jPefIR8EJetrneuqHCyZIfFgP9BguxLaeC3wUnKBX60h9m2G44FN1UnCCHtaLYz3jBx/WAz3tWa+s4YJz1Ql6oMdwYdWq7PyPZD3Qa856CdAzs/O9hXUish7okfWkCs5Z8WE90Kt0rpcRPaeqE/RAD+sFoGfWmq+j4AS9YrPeH+XDhfnIh/VAjw6naNaziQ/0QI8Op8RwYfFgJ+iBHlkvED3jVmxOs0fWA71yO5x/Sio4L7SH9UAP60VGz2ZD0AM9sh7WAz3QC7eetoLTLPxzw0Ey0OM0S7yRunEGEeuBHtbLX3CyuQB6ZL31mwsBwwWsB3pYL6b1zAyIoAd6WG8Fer1XjemOHm0W0MN60bOewXqgVyB6t8z1QA/0VBWcf7IWnJc9FrMwXQA90OMgWSzrGawHelhPUZvFONyKC3qgh/WiPvJl/xHrgR4dzujWMw40MlwAPbFv4EYy52cYsB7oYb2VHU7aLKAHelnvZlnsfYIe6NHhTHSQDOuBHh3OHBdEGKwHehScMa1nPPqbRwsNoAd6mjucBQ0XjN+Q4ZrhAuhhvRxZj4IT9GizJHxzwdBmAT2s9/U9JLCewXqgR9aTG6kbdwNiPdDDen7o7ch6oEfWU1lwug0XQA/0sJ5kh9NYmQQ90CPriRSchoJz9tuBHtZ7YK6H9apCb9OO9Yz7pdOgB3pYT8B6tiGDwXqgR9ZjuEDWw3otZD3bsWqsB3pkPSHrzW8TgR7oYT06nKCH9cq3ngE9sh7WS2Q944Mc6GE9rCeX9czyaTKsB3rNDxfWWM/55neD9bAe1otovfC3hrAe6JH1Vlgv/PJ3rAd6WG+N9XzgM6CH9UAv2HoT6E1XnYZVWaxHwSlZcC6Iz1BwYj2sJ2W9kMiH9UCv+eHCXRT0Zg+VsTSE9bCelPVO4DNYD+vVjN6tNvRm3tu7+BnrgR7Wi4eeR+QzWA/0OEgWEb3e8RpOrAd6WC8ueq7iI+uBXgtZ7yoleqfwGZ47wXpYLxV6H/AZsh7ogV5y9Jarztat14MewwUR9KbhM1gP67VlvasM6C2YjzYL6FFwSqFngY/NBaxHh1Mavd5+Q4Qh64Ee1pNDz97rxHqgVyl6D87W+yWKni3y0WYBPTqcwuj1xmA90KPDmQG9SfGR9UCPrCeP3gR8WA/0Ki049WQ9yy4f1gM9rJcEvbMbJGizgB5zvVTo9WypYz2sl77gPB+xYz3Qaz3rPSRE7xs+sh7oMVxIit7fyIf1QK8F66kpOL/Fh/VAD+ulRu/zYCfWAz3mesnRe686sR7oYb0c6PWcZgG95rMe6GE90MtivV+gh/VAr/65HuhhPayH9bAe6Gmy3h3opfhAD+thPawHeuHW+0HWI+uBHtYDPayH9ch6ZD3Qw3qgh/WwHlkP64Fe5gsisB7WA73wgpOsh/VAD+uBHsMFsh5Zj4IT9Ep57oSCk4IT9FZYj1VZ0AM9LogAPdBrp8O5pcNJ1gM93W0WrIf1/L7/Ab38hpME6owcAAAAAElFTkSuQmCC"
                      alt="">
                  </el-col> -->
                  <el-col :md="14" :lg="14">
                    <h2 style="color: black;">{{!getLaporan ? '' : getLaporan.judul}}</h2>
                    <div v-html="!getLaporan ? '' : getLaporan.deskripsi"></div>
                    <!-- <p style="font-size: 20px; color: #3498db;" v-if="kursus.is_active">Active</p>
                    <p style="font-size: 20px; color: #909399;" v-else>Inactive</p> -->
                  </el-col>
                </el-row>
              </el-card>
            </el-col>
          </el-row>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--6">
      <el-card>
        <el-tabs v-model="activeName" @tab-click="handleClick">
          <el-tab-pane label="Detail" name="detail">
            <div class="row">
              <div class="col-4">
                <b>Pelaksana Kegiatan</b>
              </div>
              <div class="col-8">
                : {{!getLaporan ? '' : getLaporan.pelaksana_kegiatan}}
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Waktu Pelaksanaan</b>
              </div>
              <div class="col-8">
                : {{!getLaporan ? '' : getLaporan.tgl_mulai}} sd {{!getLaporan ? '' : getLaporan.tgl_selesai}}
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Tempat Kegiatan</b>
              </div>
              <div class="col-8">
                : {{!getLaporan ? '' : getLaporan.tempat_kegiatan}}
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Sumber Pembiayaan</b>
              </div>
              <div class="col-8">
                : {{!getLaporan ? '' : getLaporan.sumber_pembiayaan}}
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Segmen Kegiatan</b>
              </div>
              <div class="col-8">
                : {{!getLaporan ? '' : getLaporan.segmen_kegiatan}}
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Kategori Kegiatan</b>
              </div>
              <div class="col-8">
                : {{!getLaporan ? '' : getLaporan.kategori_kegiatan}}
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Tautan</b>
              </div>
              <div class="col-8">
                : <a :href="!getLaporan ? '' : getLaporan.tautan"
                  target="_blank">{{!getLaporan ? '' : getLaporan.tautan}}</a>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Kandungan Nilai Pancasila</b>
              </div>
              <div class="col-8" v-if="getLaporan">
                : <span class="badge badge-primary" style="margin-right:10px"
                  v-for="sila in !getLaporan ? [] : getLaporan.kandungan_pancasila.split(',')" :key="sila">Sila ke
                  {{sila}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Pembuat</b>
              </div>
              <div class="col-8">
                : {{getLaporan.user ? (getLaporan.user.nama+`  (${getLaporan.user.nip})`)  : '-'}}
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <b>Goverment</b>
              </div>
              <div class="col-8">
                : {{ getLaporan.user ? (getLaporan.user.goverment ? getLaporan.user.goverment.nama : '-') : '-'}}
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane label="Evidence" name="evidence">
            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-primary btn-sm"
                  @click="downloadFile(`lapor/${getLaporan.id}/evidence/download`, true)">Download Evidence</button>
              </div>
              <div class="col-md-12" style="margin-top:20px">
                <el-upload :action="api_url + `/lapor/${getLaporan.id}/evidence/store`" :headers="headers"
                  name="evidence" :on-success="handleChangeFile" :on-remove="handleRemove" list-type="picture-card"
                  accept="image/*" :file-list="files">
                  <i class="el-icon-plus"></i>
                </el-upload>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
      </el-card>
    </div>
  </div>
</template>

<script>
  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  import {
    config
  } from '../../../global.config'

  export default {
    layout: 'admin',
    middleware: 'lapor',
    data() {
      return {
        activeName: 'detail',
        files: [],
        evidences: [],
        api_url: '',
        headers: {
          // 'Authorization': 'Bearer ' + this.$axios.g
        }
      }
    },
    mounted() {
      this.headers = this.$axios.defaults.headers.common
      this.api_url = config.baseApiUrl
      // this.$store.dispatch('lapor/getEvidenceAll', {id:this.getLaporan.id});
      this.getEvidences()
    },
    methods: {
      handleClick(current) {
        console.log(current)
      },
      handleChangeFile(response, file, fileList) {
        // let formData = new FormData;
        // formData.append('evidence', file.raw)
        // this.$axios.post(`/lapor/${this.getLaporan.id}/evidence/store`, formData).then(resp => {
        //   if (resp.data.success) {
        this.$notify.success({
          title: 'Success',
          message: 'Berhasil Menambah Evidence'
        })
        //   }
        // }).catch(e => {
        //   this.$notify.error({
        //       title: 'Error',
        //       message: e.response.data.message
        //     })
        // }).finally(() => {
        //   //
        // })
      },
      handleRemove(file, fileList) {
        if (file.id) {
          this.$axios.delete(`/lapor/${this.getLaporan.id}/evidence/${file.id}/delete`).then(resp => {
            if (resp.data.success) {
              this.$notify.success({
                title: 'Success',
                message: 'Berhasil Menghapus Evidence'
              })
            }
          }).catch(e => {
            this.$notify.error({
              title: 'Error',
              message: e.response.data.message
            })
          }).finally(() => {
            //
          })
        }
      },
      getEvidences() {
        this.$axios.get(`/lapor/${this.getLaporan.id}/evidences`).then(resp => {
          if (resp.data.success) {
            resp.data.data.multi_file.forEach(element => {
              this.files.push({
                name: element.file.file_name,
                url: element.file_url,
                id: element.id_file
              })
            });
            console.log(this.files)
          }
        }).catch(e => {
          console.log(e)
        }).finally(() => {
          //
        })
      }
    },
    computed: {
      ...mapGetters("lapor", [
        'getLaporan',
        // 'getEvidence'
      ]),
    },

  }

</script>

<style lang="scss" scoped>
  .heading {
    color: white !important;
    font-size: 25px;
    font-weight: bold;
  }

</style>
