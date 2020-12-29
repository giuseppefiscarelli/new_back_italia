<?php
$orderDirClass = $orderDir;
$orderDir = $orderDir === 'ASC' ? 'DESC' : 'ASC';

?>


<div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <form id="searchForm" method="get" action="<?=$pageUrl?>">
              <input type="hidden" name="page" id="page" value="<?=$page?>" >
                <h4 class="form-header text-uppercase"  style="font-size: 12px;margin-bottom: 10px;">
                  <i class="fa fa-search"></i>
                   Ricerca
                </h4>
                <div class="form-group row">
                  
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="search1" name="search1" value="<?=$search1?>" placeholder="Inserisci Pec Richiedente">
                  </div>
                </div> 
                <div class="form-group row">
                 
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="search2" name="search2" value="<?=$search2?>" placeholder="Inserisci Id Protocollo RAM ">
                  </div>
                </div>    


                <div class="form-group row bootstrap-select-wrapper">
                  <label for="recordsPerPage" class="col-sm-8 col-form-label">Record per Pagina</label>
                  <div class="col-sm-4">
                  <select  
                  name="recordsPerPage" 
                  id="recordsPerPage" 
                  onchange="document.forms.searchForm.submit()">
                        <option value="">Seleziona</option>
                        <?php foreach ($recordsPerPageOptions as $val){ ?>
                        
                        <option value="<?=$val?>" <?=$recordsPerPage ==$val?'selected':''?>><?=$val?></option>
                        <?php }?>
                    </select>
                  </div>
                </div>
                
                <div class="form-footer" style="margin-top: 0px;">
                    <button type="button" onclick="location.href='<?=$pageUrl?>'" id="resetBtn" class="btn btn-danger"><i class="fa fa-trash"></i> Reset</button>
                    
                    <button type="submit" onclick="document.forms.searchForm.page.value=1" class="btn btn-success"><i class="fa fa-search"></i> Ricerca</button>
                </div> 
              </form>
            </div>
          </div>
        </div>
      </div>




      
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title">Lista Istanze</h5>
           
            <small style="float: right;">Totale Istanze <b><?=$totalUsers?></b><br> Pagina <b><?=$page?></b> di <b><?=$numPages?></b></small>
            <br>
                <div class="table-responsive" style="font-size:15px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="<?=$orderBy === 'id_RAM'?$orderDirClass: '' ?> ">
                                    <a href="<?=$pageUrl?>?<?=$orderByQueryString ?>&orderBy=id&orderDir=<?=$orderDir?>">id RAM</a></th>
                                <th class="<?=$orderBy === 'data_invio'?$orderDirClass: '' ?> " >
                                    <a href="<?=$pageUrl?>?<?=$orderByQueryString ?>&orderBy=username&orderDir=<?=$orderDir?>">Data Invio</a></th>
                                <th class="<?=$orderBy === 'ragione_sociale'?$orderDirClass: '' ?> " >
                                    <a href="<?=$pageUrl?>?<?=$orderByQueryString ?>&orderBy=username&orderDir=<?=$orderDir?>">Ragione Sociale</a></th>

                                
                                <th class="<?=$orderBy === 'pec_impr'?$orderDirClass: '' ?> " >
                                    <a href="<?=$pageUrl?>?<?=$orderByQueryString ?>&orderBy=cognome&orderDir=<?=$orderDir?>">Pec Impresa</a></th>    
                                <th>Stato Istanza</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($istanze){
                                    foreach ($istanze as $i){
                                      $status=checkRend($i['id_RAM']);?>
                            <tr>
                                <td><?=$i['id_RAM']?></td>
                                <td><?=date("d/m/Y H:i",strtotime($i['data_invio']))?></td></td>
                                <td><?=$i['ragione_sociale']?></td>
                                <td><?=$i['pec']?></td>
                                <?php
                                 if($status){

                                  if($status['aperta']==true){?>
                                  <td>
                                    <span class="badge badge-primary">In Rendicontazione</span>
                                    </td>
                                    <td>
                                      <button onclick="window.location.href='istanza.php?id=<?=$i['id_RAM']?>'" type="button" class="btn btn-warning" title="Visualizza Istanza"><i class="fa fa-list" aria-hidden="true"></i></button>
                                    <?php
                                    if(!isUserUser()){?>
                                    <button type="button" onclick="infoIstanza(<?=$i['id']?>);"class="btn btn-success" title="Visualizza Info"><i class="fa fa-info" aria-hidden="true"></i></button>

                                    <?php  
                                    }
                                    ?>
                                    </td>
                                  <?php
                                  }else{?>
                                  <td>
                                    <span class="badge badge-success">In Istruttoria</span><br>
                                    Rendicondazione chiusa il <?=date("d/m/Y",strtotime($status['data_chiusura']))?>
                                    </td>
                                    <td>
                                      <button onclick="window.location.href='istanza.php?id=<?=$i['id_RAM']?>'" type="button" class="btn btn-warning" title="Visualizza Istanza"><i class="fa fa-list" aria-hidden="true"></i></button>
                                      <?php
                                    if(!isUserUser()){?>
                                    <button type="button" onclick="infoIstanza(<?=$i['id']?>);"class="btn btn-success" title="Visualizza Info"><i class="fa fa-info" aria-hidden="true"></i></button>

                                    <?php  
                                    }
                                    ?>
                                    </td>

                                  <?php
                                  
                                  }
          
                                }else{?>
                                <td>
                                  <span class="badge badge-warning">Attiva</span>
                                  </td>
                                  <td>
                                  <button type="button" onclick="infoIstanza(<?=$i['id']?>);"class="btn btn-success" title="Visualizza Info"><i class="fa fa-info" aria-hidden="true"></i></button>
                                  </td>
                                <?php
                                }
                                ?>
                            </tr>
                            <?php

                                    }
                                }else{
                                    
                                    echo '<tr><td colspan=2>NO Records Found</td></tr>';
                                }?>


                        </tbody>
                        
                        
                    

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
                            require_once 'view/template/navigation.php';
                                ?>
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="infoModal">
  <div class="modal-dialog modal-lg" role="document" style="min-width: 98%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Informazioni Istanza
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-lg-4">
            <!--start card-->
            <div class="card-wrapper">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Dati richiedente</h5>
                  <table class="table table-sm">
          
                    <tbody>
                        <tr>
                        <th scope="row">Cognome</th>
                        <td id="info_cognome"></td>
                        
                        </tr>
                        <tr>
                        <th scope="row">Nome</th>
                        <td id="info_nome"></td>
                        
                        </tr>
                        <tr>
                        <th scope="row">Data di Nascita</th>
                        <td id="info_data_nascita"></td>
                    
                        </tr>
                        <tr>
                        <th scope="row">Luogo di Nascita</th>
                        <td id="info_luogo_nascita"></td>
                    
                        </tr>
                        <tr>
                        <th scope="row">Indirizzo Residenza</th>
                        <td id="info_indirizzo_residenza"></td>
                    
                        </tr>
                        <tr>
                        <th scope="row">Comune Residenza</th>
                        <td id="info_comune_residenza"></td>
                    
                        </tr>
                        <tr>
                        <th scope="row">email</th>
                        <td id="info_email_richiedente"></td>
                    
                        </tr>
                        
                        <tr>
                        <th scope="row">Tipo</th>
                        <td id="info_tipo"></td>
                    
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--end card-->
          </div>
          <div class="col-12 col-lg-8">
            <!--start card-->
            <div class="card-wrapper">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Dati Impresa</h5>
                  <div class="row">
                    <div class="col-lg-6 col-12">
                        <table class="table table-sm">
                
                            <tbody>
                                <tr>
                                <th scope="row">Ragione Sociale</th>
                                <td id="info_ragione_sociale"></td>
                                
                                </tr>
                                <tr>
                                <th scope="row">Partita IVA</th>
                                <td id="info_piva"></td>
                            
                                </tr>
                                <tr>
                                <th scope="row">Codice Fiscale</th>
                                <td id="info_cf"></td>
                            
                                </tr>
                                
                                
                                
                                <tr>
                                <th scope="row">Indirizzo Impresa</th>
                                <td id="info_indirizzo_impresa"></td>
                            
                                </tr>
                                <tr>
                                <th scope="row">Comune Impresa</th>
                                <td id="info_comune_impresa"></td>
                            
                                </tr>
                                
                                <tr>
                                <th scope="row">Email Impresa</th>
                                <td id="info_email_impr"></td>
                            
                                </tr>
                                <tr>
                                <th scope="row">Pec Impresa</th>
                                <td id="info_pec_impr"></td>
                            
                                </tr>
                                <tr>
                                <th scope="row">Telefono Impresa</th>
                                <td id="info_tel_impr"></td>
                            
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 col-12"> 
                        <table class="table table-sm">
                            <tbody>
                            
                                <tr>
                                <th scope="row">Tipo Impresa</th>
                                <td id="info_tipo_impresa"></td>
                                </tr>
                                <tr>
                                <th scope="row">Codice Albo</th>
                                <td id="info_codice_albo"></td>
                                </tr>
                                <tr>
                                <th scope="row">Codice Ren</th>
                                <td id="info_codice_ren"></td>
                                </tr>
                                <tr>
                                <th scope="row">CCIAA</th>
                                <td id="info_cciaa"></td>
                                </tr>
                                <tr>
                                <th scope="row">Codice A.TE.CO</th>
                                <td id="info_codice_ateco"></td>
                                </tr>
                                <tr>
                                <th scope="row">Banca</th>
                                <td id="info_banca"></td>
                                </tr>
                                <tr>
                                <th scope="row">Maggiorazione PMI</th>
                                <td id="info_pmi"></td>
                                </tr>
                                <tr>
                                <th scope="row">Maggiorazione Contratto rete d'imprese</th>
                                <td id="info_rete"></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                  </div>

                  
                </div>
              </div>
            </div>
            <!--end card-->
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <table class="table table-sm table-bordered" style="font-size:smaller;">
              <thead >
                <tr >
                  <th colspan="5" style="text-align:center;">
                  Acquisizione dei veicoli a trazione alternativa a metano CNG e gas naturale liquefatto LNG, nonché a trazione elettrica - art. 1, comma 5, lett. a  
                  </th>      
                </tr>
                <tr >
                  <th style="text-align:center;">alimentazione
                  </th>
                  <th style="text-align:center;">massa<br> complessiva
                  </th>
                  <th style="text-align:center;">numero<br> veicoli
                  </th>
                  <th style="text-align:center;">spesa prevista<br> (IVA esclusa)
                  </th>
                  <th style="text-align:center;">eventuale<br> rottamazione
                  </th>      
                </tr>
              </thead>
              <tbody>
              <tr>
                <td rowspan="3" style="vertical-align:middle;text-align:center;">CNG</td>
                <td>DA 3,5 A 7 T.</td>
                <td id="info_nv1"></td>
                <td id="info_sp1"></td>
                <td id="info_rott1"></td>                  
              </tr>

              <tr>
               
                <td>OLTRE 7 E MENO DI 16 T.</td>
                <td id="info_nv2"></td>
                <td id="info_sp2"></td>
                <td id="info_rott2"></td>
              </tr>

              <tr>
               
                <td>DA 16 T.</td>
                <td id="info_nv3"></td>
                <td id="info_sp3"></td>
                <td id="info_rott3"></td>
              </tr>

              <tr>
                <td rowspan="2" style="vertical-align:middle;text-align:center;">LNG</td>
                <td>DA 7 E MENO DI 16 T.</td>
                <td id="info_nv4"></td>
                <td id="info_sp4"></td>
                <td id="info_rott4"></td>
              </tr>

              <tr>
                
                <td>DA 16 T.</td>
                <td id="info_nv5"></td>
                <td id="info_sp5"></td>
                <td id="info_rott5"></td>
              </tr>

              <tr>
                <td rowspan="3" style="vertical-align:middle;text-align:center;">IBRIBA<br>(diesel/elettrico)</td>
                <td>DA 3,5 A 7 T.</td>
                <td id="info_nv6"></td>
                <td id="info_sp6"></td>
                <td id="info_rott6"></td>
              </tr>

              <tr>
                
                <td>OLTRE 7 E MENO DI 16 T.</td>
                <td id="info_nv7"></td>
                <td id="info_sp7"></td>
                <td id="info_rott7"></td>
              </tr>

              <tr>
                
                <td>DA 16 T.</td>
                <td id="info_nv8"></td>
                <td id="info_sp8"></td>
                <td id="info_rott8"></td>
              </tr>

              <tr>
                <td rowspan="2" style="vertical-align:middle;text-align:center;">ELETTRICA</td>
                <td>DA 3,5 A 7 T.</td>
                <td id="info_nv9"></td>
                <td id="info_sp9"></td>
                <td id="info_rott9"></td>
              </tr>

              <tr>
               
                <td>OLTRE 7 T.</td>
                <td id="info_nv10"></td>
                <td id="info_sp10"></td>
                <td id="info_rott10"></td>
              </tr>

              <tr>
                <td style="vertical-align:middle;text-align:center;">Dispositivi per la<br>riconversione a<br>trazione elettrica</td>
                <td>3,5 T.</td>
                <td id="info_nv11"></td>
                <td id="info_sp11"></td>
                <td ></td>
              </tr>

              </tbody>          
            </table>
          
          </div>
          <div class="col-6">
          <table class="table table-sm table-bordered" style="font-size:smaller;">
              <thead>
                <tr>
                  <th colspan="4" style="text-align:center;">Radiazione per rottamazione di veicoli pesanti di massa complessiva a pieno carico pari o superiore a 11,5 tonnellate, con contestuale acquisizione di veicoli nuovi di fabbrica art. 1, comma 5, lett. b</th>
                </tr>
                <tr>
                  <th style="vertical-align:middle;text-align:center;">Tipo veicolo</th>
                  <th style="vertical-align:middle;text-align:center;">numero veicoli<br>per tipologia</th>
                  <th style="vertical-align:middle;text-align:center;">spesa prevista<br>(IVA esclusa)</th>
                  <th style="vertical-align:middle;text-align:center;">Numero veicoli<br>rottamati</th>
                </tr>
              </thead>
              <tbody>
              <tr>
                <td  style="vertical-align:middle;text-align:center;">VEICOLI EURO 6 DI MASSA<br>COMPRESA FRA 7 E 16 T.</td>
                <td id="info_r_nv_1"></td>
                <td id="info_r_sp_1"></td>
                <td id="info_r_rott_1"></td>
              </tr>
              <tr>
                <td  style="vertical-align:middle;text-align:center;">VEICOLI EURO 6 DI MASSA<br>SUPERIORE A 16 T.</td>
                <td id="info_r_nv_2"></td>
                <td id="info_r_sp_2"></td>
                <td id="info_r_rott_2"></td>
              </tr>
              <tr>
                <td  style="vertical-align:middle;text-align:center;">VEICOLI EURO 6 DTEMP DI MASSA<br>DA 3,5 E INFERIORE A 7 T.</td>
                <td id="info_r_nv_3"></td>
                <td id="info_r_sp_3"></td>
                <td id="info_r_rott_3"></td>
              </tr>

              </tbody>
          </table>

          <table class="table table-sm table-bordered" style="font-size:smaller;">
              <thead>
                <tr>
                  <th colspan="4" style="text-align:center;">ACQUISIZIONE ANCHE MEDIANTE LOCAZIONE FINANZIARIA, DI RIMORCHI E SEMIRIMORCHI, NUOVI DI FABBRICA, PER IL TRASPORTO COMBINATO – ART. 1, COMMA 5, LETT. C</th>
                </tr>
               
              </thead>
              <tbody>
              <tr>
                <td  colspan="2" rowspan="2"style="vertical-align:middle;text-align:center;">Rimorchi o semirimorchi UIC e IMO ciascuno<br>dotato di almeno uno dei dispositivi innovativi di cui<br>all’allegato 1 del D.M. 203 - 12 maggio 2020</td>
                <th style="vertical-align:middle;text-align:center;">Nr. rimorchi o<br>semirimorchi:</th>
                <th style="vertical-align:middle;text-align:center;">Spesa prevista<br>(IVA esclusa)</th>
              </tr>
              <tr>
                <td id="info_nr_1"></td>
                <td id="info_spr_1"></td>


              </tr>

              </tbody>
          </table> 

          <table class="table table-sm table-bordered" style="font-size:smaller;">
              <thead>
                <tr>
                  <th colspan="4" style="text-align:center;">RIMORCHI, SEMIRIMORCHI E EQUIPAGGIAMENTI PER AUTOVEICOLI SPECIFICI SUPERIORI A 7 TONNELLATE ALLESTITI PER TRASPORTI IN REGIME ATP E SOSTITUZIONE DELLE UNITÀ FRIGORIFERE/CALORIFERE ART. 1, COMMA 5, LETT. C</th>
                </tr>
               
              </thead>
              <tbody>
              <tr>
                <td  colspan="2" rowspan="2"style="vertical-align:middle;text-align:center;width:63%;">Rimorchi, semirimorchi e equipaggiamenti, sostituzione delle unità frigorifere/calorifere installate, per veicoli superiori a 7 t.</td>
                <th style="vertical-align:middle;text-align:center;">Nr. rimorchi, semirimorchi<br> ed equipaggiamenti</th>
                <th style="vertical-align:middle;text-align:center;">Spesa prevista<br>(IVA esclusa)</th>
              </tr>
              <tr>
                <td id="info_nr_2"></td>
                <td id="info_spr_2"></td>


              </tr>

              </tbody>
          </table> 

          <table class="table table-sm table-bordered" style="font-size:smaller;">
              <thead>
                <tr>
                  <th colspan="4" style="text-align:center;">ACQUISIZIONE DI GRUPPI DI CASSE MOBILI E RIMORCHI O SEMIRIMORCHI PORTACASSE ART. 1, COMMA 5, LETT. D</th>
                </tr>
               
              </thead>
              <tbody>
              <tr>
                <td  colspan="2" rowspan="2"style="vertical-align:middle;text-align:center;width:63%;">Gruppo costituito da 8 (otto) casse mobili ed un rimorchio o semirimorchio portacasse</td>
                <th style="vertical-align:middle;text-align:center;">Nr. gruppi</th>
                <th style="vertical-align:middle;text-align:center;">Spesa prevista<br>(IVA esclusa)</th>
              </tr>
              <tr>
                <td id="info_ng_1"></td>
                <td id="info_spg_1"></td>


              </tr>

              </tbody>
          </table> 

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary btn-sm" data-dismiss="modal" type="button">Chiudi</button>
      </div>
    </div>
  </div>
</div>