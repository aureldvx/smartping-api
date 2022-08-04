<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum ApiEndpoint: string
{
    // Commun
    case XML_INITIALISATION = '/xml_initialisation.php';
    case XML_NEW_ACTU = '/xml_new_actu.php';
    // Organismes
    case XML_ORGANISME = '/xml_organisme.php';
    // Clubs
    case XML_CLUB_DEP_2 = '/xml_club_dep2.php';
    case XML_CLUB_B = '/xml_club_b.php';
    case XML_CLUB_DETAIL = '/xml_club_detail.php';
    // Compétitions
    case XML_EPREUVE = '/xml_epreuve.php';
    case XML_DIVISION = '/xml_division.php';
    case XML_RESULT_EQU = '/xml_result_equ.php';
    case XML_CHP_RENC = '/xml_chp_renc.php';
    case XML_EQUIPE = '/xml_equipe.php';
    case XML_RESULT_INDIV = '/xml_result_indiv.php';
    case XML_RES_CLA = '/xml_res_cla.php';
    // Joueurs
    case XML_LISTE_JOUEUR = '/xml_liste_joueur.php';
    case XML_LISTE_JOUEUR_O = '/xml_liste_joueur_o.php';
    case XML_JOUEUR = '/xml_joueur.php';
    case XML_LICENCE = '/xml_licence.php';
    case XML_LICENCE_B = '/xml_licence_b.php';
    case XML_PARTIE_MYSQL = '/xml_partie_mysql.php';
    case XML_PARTIE = '/xml_partie.php';
    case XML_HISTO_CLASSEMENT = '/xml_histo_classement.php';
}
