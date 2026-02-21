using System;
using UnityEngine;

namespace NyaniShogi.Core
{
    /// <summary>
    /// 駒の種類を定義します。
    /// </summary>
    public enum PieceType
    {
        King,   // 王将 (猫)
        Gold,   // 金将 (うさぎ)
        Rook,   // 飛車 (ひよこ)
        Bishop, // 角行 (パンダ)
        Pawn    // 歩兵 (ねずみ)
    }

    /// <summary>
    /// 駒の所有者（先手・後手）を定義します。
    /// </summary>
    public enum Owner
    {
        Player1, // 先手 (明るい色)
        Player2  // 后手 (くすみ色)
    }

    /// <summary>
    /// 駒の基本データを保持する構造体です。
    /// </summary>
    [Serializable]
    public struct PieceData
    {
        public PieceType type;
        public Owner owner;

        public PieceData(PieceType type, Owner owner)
        {
            this.type = type;
            this.owner = owner;
        }
    }
}
